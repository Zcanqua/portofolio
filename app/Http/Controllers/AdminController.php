<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class AdminController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ((bool) $request->session()->get('portfolio_admin_authenticated')) {
            return redirect()->route('admin.projects.index');
        }

        return view('admin.login', [
            'configured' => User::query()->where('is_admin', true)->exists(),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:200'],
        ]);
        $identifier = Str::lower(trim($credentials['identifier']));

        $admin = User::query()
            ->where('is_admin', true)
            ->where(function ($query) use ($identifier) {
                $query->whereRaw('LOWER(username) = ?', [$identifier])
                    ->orWhereRaw('LOWER(email) = ?', [$identifier]);
            })
            ->first();
        $loginSubject = $admin === null ? 'identifier:'.$identifier : 'user:'.$admin->getKey();
        $attemptKey = $this->loginAttemptCacheKey($loginSubject);
        $lockKey = $this->loginLockCacheKey($loginSubject);

        if (Cache::has($lockKey)) {
            throw ValidationException::withMessages([
                'identifier' => 'Terlalu banyak percobaan login. Akun dikunci selama 6 jam sejak percobaan ketiga.',
            ]);
        }

        if ($admin === null || ! Hash::check($credentials['password'], $admin->password)) {
            Cache::add($attemptKey, 0, now()->addHours(6));
            $attempts = Cache::increment($attemptKey);

            if ($attempts >= 3) {
                $lockedUntil = now()->addHours(6);
                Cache::put($lockKey, $lockedUntil->timestamp, $lockedUntil);
                Cache::forget($attemptKey);

                throw ValidationException::withMessages([
                    'identifier' => 'Tiga percobaan login gagal. Akses untuk identitas ini dikunci selama 6 jam.',
                ]);
            }

            throw ValidationException::withMessages([
                'identifier' => 'Username/email atau kata sandi tidak valid.',
            ]);
        }

        Cache::forget($attemptKey);
        $request->session()->regenerate();
        $request->session()->put([
            'portfolio_admin_authenticated' => true,
            'portfolio_admin_user_id' => $admin->id,
        ]);

        return redirect()->route('admin.projects.index');
    }

    public function index(Request $request, ProjectRepository $projects): View
    {
        $admin = User::query()
            ->whereKey($request->session()->get('portfolio_admin_user_id'))
            ->where('is_admin', true)
            ->firstOrFail();

        return view('admin.projects', [
            'projects' => $projects->all(),
            'certificates' => Certificate::query()->orderByDesc('year')->orderBy('title')->get(),
            'profileImage' => $admin->profile_image ?: 'images/profile.jpg',
        ]);
    }

    public function storeCertificate(Request $request): RedirectResponse
    {
        $data = $this->validatedCertificate($request);
        $data['image'] = $request->hasFile('image') ? $this->storeCertificateImage($request) : null;
        Certificate::query()->create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Sertifikat berhasil ditambahkan.');
    }

    public function updateCertificate(Request $request, int $id): RedirectResponse
    {
        $data = $this->validatedCertificate($request);
        $certificate = Certificate::query()->find($id);

        if ($certificate === null) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Sertifikat tidak ditemukan. Muat ulang dashboard lalu coba lagi.');
        }

        $previousImage = $certificate->image;
        $data['image'] = $request->hasFile('image')
            ? $this->storeCertificateImage($request)
            : $previousImage;
        $certificate->update($data);

        if ($previousImage !== $certificate->image && $previousImage !== null) {
            $this->deleteUploadedImage($previousImage);
        }

        return redirect()->route('admin.projects.index')->with('status', 'Sertifikat berhasil diperbarui.');
    }

    public function destroyCertificate(int $id): RedirectResponse
    {
        $certificate = Certificate::query()->find($id);

        if ($certificate === null) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Sertifikat tidak ditemukan. Muat ulang dashboard lalu coba lagi.');
        }

        $image = $certificate->image;
        $certificate->delete();

        if ($image !== null) {
            $this->deleteUploadedImage($image);
        }

        return redirect()->route('admin.projects.index')->with('status', 'Sertifikat berhasil dihapus.');
    }

    public function updateProfilePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $admin = User::query()
            ->whereKey($request->session()->get('portfolio_admin_user_id'))
            ->where('is_admin', true)
            ->firstOrFail();

        $previousImage = $admin->profile_image;
        $admin->profile_image = $this->storeProfileImage($request);
        $admin->save();

        if ($previousImage !== null) {
            $this->deleteUploadedImage($previousImage);
        }

        return redirect()->route('admin.projects.index')->with('status', 'Foto profil berhasil diperbarui.');
    }

    public function store(Request $request, ProjectRepository $projects): RedirectResponse
    {
        $data = $this->validatedProject($request);
        $id = Str::slug($data['title']) ?: Str::uuid()->toString();
        $baseId = $id;
        $suffix = 2;

        while ($projects->exists($id)) {
            $id = $baseId.'-'.$suffix++;
        }

        $project = $this->makeProject($data, $id, $request);
        $projects->create($project);

        return redirect()->route('admin.projects.index')->with('status', 'Proyek berhasil ditambahkan.');
    }

    public function update(Request $request, string $id, ProjectRepository $projects): RedirectResponse
    {
        $data = $this->validatedProject($request);
        $previousProject = $projects->find($id);

        if ($previousProject === null) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Proyek tidak ditemukan. Daftar proyek mungkin sudah berubah; muat ulang halaman lalu coba lagi.');
        }

        $previousImage = $previousProject['image'];
        $project = $this->makeProject($data, $id, $request, $previousImage);
        $projects->update($id, $project);

        if ($previousImage !== $project['image']) {
            $this->deleteUploadedImage($previousImage);
        }

        return redirect()->route('admin.projects.index')->with('status', 'Proyek berhasil diperbarui.');
    }

    public function destroy(string $id, ProjectRepository $projects): RedirectResponse
    {
        $deleted = $projects->find($id);

        if ($deleted === null) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Proyek tidak ditemukan. Daftar proyek mungkin sudah berubah; muat ulang halaman lalu coba lagi.');
        }

        $projects->delete($id);
        $this->deleteUploadedImage($deleted['image']);

        return redirect()->route('admin.projects.index')->with('status', 'Proyek berhasil dihapus.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * @return array{title: string, category: string, description: string, image_alt: string, url: string, technologies: string}
     */
    private function validatedProject(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:1500'],
            'image_alt' => ['required', 'string', 'max:180'],
            'url' => ['nullable', 'url:http,https', 'max:2048'],
            'technologies' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    /**
     * @return array{title: string, issuer: string, year: int, description: string|null, url: string|null}
     */
    private function validatedCertificate(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'issuer' => ['required', 'string', 'max:120'],
            'year' => ['required', 'integer', 'min:1900', 'max:'.(now()->year + 10)],
            'description' => ['nullable', 'string', 'max:1000'],
            'url' => ['nullable', 'url:http,https', 'max:2048'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    /**
     * @param array{title: string, category: string, description: string, image_alt: string, url?: string|null, technologies?: string|null} $data
     * @return array{id: string, title: string, category: string, description: string, image: string, image_alt: string, url: string, technologies: list<string>}
     */
    private function makeProject(array $data, string $id, Request $request, string $previousImage = ''): array
    {
        return [
            'id' => $id,
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'image' => $request->hasFile('image') ? $this->storeImage($request, $id) : $previousImage,
            'image_alt' => $data['image_alt'],
            'url' => $data['url'] ?? '',
            'technologies' => array_values(array_filter(array_map('trim', explode(',', $data['technologies'] ?? '')))),
        ];
    }

    private function storeImage(Request $request, string $id): string
    {
        $directory = public_path('images/projects');

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the project image directory.');
        }

        $image = $request->file('image');
        $filename = $id.'-'.Str::uuid().'.'.$image->extension();
        $image->move($directory, $filename);

        return 'images/projects/'.$filename;
    }

    private function storeProfileImage(Request $request): string
    {
        $directory = public_path('images/profiles');

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the profile image directory.');
        }

        $image = $request->file('profile_image');
        $filename = 'profile-'.Str::uuid().'.'.$image->extension();
        $image->move($directory, $filename);

        return 'images/profiles/'.$filename;
    }

    private function storeCertificateImage(Request $request): string
    {
        $directory = public_path('images/certificates');

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the certificate image directory.');
        }

        $image = $request->file('image');
        $filename = 'certificate-'.Str::uuid().'.'.$image->extension();
        $image->move($directory, $filename);

        return 'images/certificates/'.$filename;
    }

    private function deleteUploadedImage(string $image): void
    {
        if (! Str::startsWith($image, ['images/projects/', 'images/profiles/', 'images/certificates/'])) {
            return;
        }

        $path = public_path($image);

        if (is_file($path) && ! unlink($path)) {
            throw new RuntimeException('Unable to delete the replaced project image.');
        }
    }

    private function loginAttemptCacheKey(string $subject): string
    {
        return 'admin-login:attempts:'.hash('sha256', $subject);
    }

    private function loginLockCacheKey(string $subject): string
    {
        return 'admin-login:locked:'.hash('sha256', $subject);
    }
}
