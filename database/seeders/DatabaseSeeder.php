<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $username = (string) config('admin.username');
        $password = (string) config('admin.password');

        if ($username === '' || $password === '') {
            throw new RuntimeException('Set ADMIN_USERNAME and ADMIN_PASSWORD in .env before seeding the administrator.');
        }

        User::query()->updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Administrator',
                'email' => (Str::slug($username) ?: 'admin').'@admin.portfolio.local',
                'password' => $password,
                'is_admin' => true,
            ],
        );
    }
}
