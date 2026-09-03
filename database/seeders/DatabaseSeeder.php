<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_aktif' => 1,
        ]);

        // Petugas
        User::create([
            'nama_lengkap' => 'Petugas Parkir',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'status_aktif' => 1,
        ]);

        // Owner
        User::create([
            'nama_lengkap' => 'Owner / Pemilik',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
            'status_aktif' => 1,
        ]);
    }
}
