<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin KGP',
                'email' => 'superadmin@kgp.co.id',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin KGP',
                'email' => 'admin@kgp.co.id',
                'role' => 'admin',
            ],
            [
                'name' => 'Editor Berita',
                'email' => 'editor@kgp.co.id',
                'role' => 'editor',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
