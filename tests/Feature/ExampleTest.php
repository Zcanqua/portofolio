<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_portfolio_contains_the_required_sections_and_empty_project_state(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee(asset('images/favicon.png'), false)
            ->assertSee('Ricky Kurniawan')
            ->assertSee('Tailwind CSS')
            ->assertSee('Universitas Teknokrat Indonesia')
            ->assertSee('id="about"', false)
            ->assertSee('id="skills"', false)
            ->assertSee('id="projects"', false)
            ->assertSee('id="experience"', false)
            ->assertSee('id="certificates"', false)
            ->assertSee('hero-student-badge', false)
            ->assertSee('hero-student-dot', false)
            ->assertSee('PROGRAMMER')
            ->assertSee('href="'.route('contact').'"', false)
            ->assertDontSee('id="contact"', false)
            ->assertDontSee('06 / KONTAK')
            ->assertSee('Belum ada proyek yang ditambahkan.')
            ->assertSee('images/profile.jpg')
            ->assertDontSee('yojinn.kesug.com')
            ->assertDontSee('/admin')
            ->assertSee('Sertifikat yang ditambahkan melalui dashboard admin akan tampil di sini.');
    }

    public function test_the_contact_page_shows_the_available_contact_channels(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200)
            ->assertSee(asset('images/favicon.png'), false)
            ->assertSee('Ricky Kurniawan')
            ->assertSee('Instagram')
            ->assertSee('Telegram')
            ->assertSee('ricky_sakurniawan@teknokrat.ac.id')
            ->assertSee('WhatsApp')
            ->assertSee('https://wa.me/6285187094538', false);
    }

    public function test_admin_is_protected_and_projects_can_be_managed_after_login(): void
    {
        config([
            'admin.username' => 'test-admin',
            'admin.password' => 'correct-horse-battery-staple',
        ]);
        User::query()->create([
            'name' => 'Administrator',
            'username' => 'test-admin',
            'email' => 'test-admin@admin.portfolio.local',
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);

        $this->get('/admin')
            ->assertOk()
            ->assertSee(asset('images/favicon.png'), false);

        $this->get('/admin/projects')->assertRedirect(route('admin.login'));

        $this->post('/admin/login', [
            'identifier' => 'test-admin',
            'password' => 'incorrect-password',
        ])->assertSessionHasErrors('identifier');

        $this->post('/admin/login', [
            'identifier' => 'test-admin',
            'password' => 'correct-horse-battery-staple',
        ])->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('users', ['username' => 'test-admin', 'is_admin' => true]);

        $this->get('/admin/projects')
            ->assertOk()
            ->assertSee(asset('images/favicon.png'), false)
            ->assertSee('Tambah proyek')
            ->assertSee('Tambah sertifikat')
            ->assertSee('profile-crop-canvas', false)
            ->assertSee('profile-zoom', false);
        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->get('/admin/projects')->assertRedirect(route('admin.login'));

        $this->post('/admin/login', [
            'identifier' => 'TEST-ADMIN@ADMIN.PORTFOLIO.LOCAL',
            'password' => 'correct-horse-battery-staple',
        ])->assertRedirect(route('admin.projects.index'));
    }

    public function test_revoked_or_deleted_admin_accounts_lose_access_to_admin_routes(): void
    {
        $admin = User::query()->create([
            'name' => 'Revoked Administrator',
            'username' => 'revoked-admin',
            'email' => 'revoked-admin@admin.portfolio.local',
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);
        $this->withSession([
            'portfolio_admin_authenticated' => true,
            'portfolio_admin_user_id' => $admin->id,
        ]);

        $admin->update(['is_admin' => false]);

        $this->post('/admin/projects', [
            'title' => 'Unauthorized Project',
            'category' => 'WEB PROJECT',
            'description' => 'Must not be created.',
            'image_alt' => 'Unauthorized project',
        ])->assertRedirect(route('admin.login'))
            ->assertSessionMissing('portfolio_admin_authenticated');

        $this->assertDatabaseMissing('projects', ['id' => 'unauthorized-project']);
    }

    public function test_three_failed_admin_logins_lock_the_identifier_for_six_hours(): void
    {
        Cache::setDefaultDriver('array');
        $lockedAt = now();
        $this->travelTo($lockedAt);
        $identifier = 'lockout-admin@example.test';
        $admin = User::query()->create([
            'name' => 'Lockout Administrator',
            'username' => 'lockout-admin',
            'email' => $identifier,
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);

        foreach (range(1, 2) as $attempt) {
            $this->post('/admin/login', [
                'identifier' => $identifier,
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('identifier');
        }

        $this->post('/admin/login', [
            'identifier' => $identifier,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('identifier', 'Tiga percobaan login gagal. Akses untuk identitas ini dikunci selama 6 jam.');

        $lockKey = 'admin-login:locked:'.hash('sha256', 'user:'.$admin->id);
        $this->assertSame($lockedAt->copy()->addHours(6)->timestamp, Cache::get($lockKey));
        $this->post('/admin/login', [
            'identifier' => 'lockout-admin',
            'password' => 'correct-horse-battery-staple',
        ])->assertSessionHasErrors('identifier');
        $this->post('/admin/login', [
            'identifier' => $identifier,
            'password' => 'correct-horse-battery-staple',
        ])->assertSessionHasErrors('identifier');

        $this->travel(6)->hours();
        $this->post('/admin/login', [
            'identifier' => $identifier,
            'password' => 'correct-horse-battery-staple',
        ])->assertRedirect(route('admin.projects.index'));
        Cache::forget($lockKey);
    }

    public function test_admin_can_create_update_and_delete_a_project_in_database(): void
    {
        Project::query()->delete();
        $admin = User::query()->create([
            'name' => 'Project Administrator',
            'username' => 'project-admin',
            'email' => 'project-admin@admin.portfolio.local',
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);
        $this->withSession([
            'portfolio_admin_authenticated' => true,
            'portfolio_admin_user_id' => $admin->id,
        ]);
        $image = UploadedFile::fake()->createWithContent(
            'project.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC')
        );

        $this->post('/admin/projects', [
            'title' => 'Project Test',
            'category' => 'ON PROGRESS',
            'description' => 'Deskripsi proyek tes.',
            'image_alt' => 'Gambar proyek tes',
            'url' => 'https://example.com',
            'technologies' => 'Laravel, PHP',
            'image' => $image,
        ])->assertRedirect(route('admin.projects.index'));

        $savedProject = Project::query()->findOrFail('project-test')->toArray();
        $this->assertSame('project-test', $savedProject['id']);
        $this->assertDatabaseHas('projects', ['id' => 'project-test', 'title' => 'Project Test']);
        $this->assertFileExists(public_path($savedProject['image']));
        $this->get('/')->assertSee('Project Test')->assertSee('https://example.com', false);

        $this->put('/admin/projects/project-test', [
            'title' => 'Project Updated',
            'category' => 'WEB PROJECT',
            'description' => 'Deskripsi terbaru.',
            'image_alt' => 'Gambar proyek terbaru',
            'url' => '',
            'technologies' => 'PHP',
        ])->assertRedirect(route('admin.projects.index'));

        $this->get('/')->assertSee('Project Updated')->assertDontSee('Project Test');

        $this->delete('/admin/projects/project-test')->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseMissing('projects', ['id' => 'project-test']);
        $this->assertFileDoesNotExist(public_path($savedProject['image']));
        $this->get('/')->assertDontSee('Project Updated');
    }

    public function test_updating_a_missing_project_returns_to_the_dashboard_with_an_explanation(): void
    {
        $admin = User::query()->create([
            'name' => 'Project Administrator',
            'username' => 'missing-project-admin',
            'email' => 'missing-project-admin@admin.portfolio.local',
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);
        $this->withSession([
            'portfolio_admin_authenticated' => true,
            'portfolio_admin_user_id' => $admin->id,
        ]);

        $this->put('/admin/projects/nonexistent', [
            'title' => 'Project Test',
            'category' => 'ON PROGRESS',
            'description' => 'Deskripsi proyek tes.',
            'image_alt' => 'Gambar proyek tes',
            'url' => '',
            'technologies' => '',
        ])->assertRedirect(route('admin.projects.index'))
            ->assertSessionHas('error');
    }

    public function test_admin_can_change_profile_photo_and_portfolio_uses_the_uploaded_photo(): void
    {
        $admin = User::query()->create([
            'name' => 'Administrator',
            'username' => 'photo-admin',
            'email' => 'photo-admin@admin.portfolio.local',
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);
        $this->withSession([
            'portfolio_admin_authenticated' => true,
            'portfolio_admin_user_id' => $admin->id,
        ]);

        $image = UploadedFile::fake()->createWithContent(
            'profile.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC')
        );

        $this->post('/admin/profile/photo', ['profile_image' => $image])
            ->assertRedirect(route('admin.projects.index'));

        $admin->refresh();
        $this->assertNotNull($admin->profile_image);
        $this->assertFileExists(public_path($admin->profile_image));
        $this->get('/')->assertSee(asset($admin->profile_image), false);
        $this->get('/admin/projects')->assertOk()->assertSee('Foto profil');

        $previousImage = $admin->profile_image;
        $replacement = UploadedFile::fake()->createWithContent(
            'replacement.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC')
        );

        $this->post('/admin/profile/photo', ['profile_image' => $replacement])
            ->assertRedirect(route('admin.projects.index'));

        $admin->refresh();
        $this->assertNotSame($previousImage, $admin->profile_image);
        $this->assertFileDoesNotExist(public_path($previousImage));
        $this->assertFileExists(public_path($admin->profile_image));

        $currentImage = $admin->profile_image;
        $admin->profile_image = null;
        $admin->save();
        unlink(public_path($currentImage));
    }

    public function test_admin_can_create_update_and_delete_certificates_shown_on_portfolio(): void
    {
        $admin = User::query()->create([
            'name' => 'Certificate Administrator',
            'username' => 'certificate-admin',
            'email' => 'certificate-admin@admin.portfolio.local',
            'password' => 'correct-horse-battery-staple',
            'is_admin' => true,
        ]);
        $this->withSession([
            'portfolio_admin_authenticated' => true,
            'portfolio_admin_user_id' => $admin->id,
        ]);
        $image = UploadedFile::fake()->createWithContent(
            'certificate.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC')
        );

        $this->post('/admin/certificates', [
            'title' => 'Laravel Fundamentals',
            'issuer' => 'Dicoding',
            'year' => now()->year,
            'description' => 'Sertifikat pengembangan web.',
            'url' => 'https://example.com/certificates/laravel',
            'image' => $image,
        ])->assertRedirect(route('admin.projects.index'));

        $certificate = Certificate::query()->where('title', 'Laravel Fundamentals')->firstOrFail();
        $this->assertFileExists(public_path($certificate->image));
        $this->get('/')
            ->assertSee('Laravel Fundamentals')
            ->assertSee('Dicoding')
            ->assertSee('https://example.com/certificates/laravel', false)
            ->assertSee(asset($certificate->image), false);

        $this->put('/admin/certificates/'.$certificate->id, [
            'title' => 'Laravel Advanced',
            'issuer' => 'Universitas Teknokrat Indonesia',
            'year' => now()->year - 1,
            'description' => 'Materi lanjutan.',
            'url' => '',
        ])->assertRedirect(route('admin.projects.index'));

        $this->get('/')
            ->assertSee('Laravel Advanced')
            ->assertSee('Universitas Teknokrat Indonesia')
            ->assertDontSee('Laravel Fundamentals');

        $imagePath = public_path($certificate->image);
        $this->delete('/admin/certificates/'.$certificate->id)
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseMissing('certificates', ['id' => $certificate->id]);
        $this->assertFileDoesNotExist($imagePath);
        $this->get('/')->assertSee('Sertifikat yang ditambahkan melalui dashboard admin akan tampil di sini.');
    }
}
