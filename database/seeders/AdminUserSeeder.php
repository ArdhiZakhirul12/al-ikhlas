<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@alikhlas.test')],
            [
                'name' => env('ADMIN_NAME', 'Admin Masjid Al Ikhlas'),
                'password' => env('ADMIN_PASSWORD', 'admin12345'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
