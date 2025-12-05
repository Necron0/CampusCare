<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'role' => 'admin',
                'name' => 'Admin Utama',
                'email' => 'admin@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Budi Apotek',
                'email' => 'mitra1@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Siti Farma',
                'email' => 'mitra2@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Andi Medika',
                'email' => 'mitra3@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Dewi Kesehatan',
                'email' => 'mitra4@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Eko Guardian',
                'email' => 'mitra5@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'pengguna',
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'pengguna',
                'name' => 'Siti Rahmawati',
                'email' => 'siti@email.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
