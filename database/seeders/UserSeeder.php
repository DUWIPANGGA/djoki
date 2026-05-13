<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin D\'JOKI',
            'username' => 'admin_djoki',
            'email' => 'admin@djoki.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Provider (Freelancer)
        User::create([
            'name' => 'Budi Joki IT',
            'username' => 'budijoki',
            'email' => 'provider@djoki.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'bio' => 'Fullstack developer siap membantu tugas IT Anda.',
            'verification_status' => 'verified',
            'provider_verified_at' => now(),
            'rating_avg' => 4.8,
            'is_active' => true,
        ]);

        // Client (User)
        User::create([
            'name' => 'Andi Mahasiswa',
            'username' => 'andiam',
            'email' => 'client@djoki.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'is_active' => true,
        ]);

        // Additional Random Providers
        User::create([
            'name' => 'Siska Code',
            'username' => 'siskacode',
            'email' => 'siska@example.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'bio' => 'Spesialis Laravel dan Vue.js.',
            'verification_status' => 'verified',
            'provider_verified_at' => now(),
            'rating_avg' => 4.5,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Reza Mobile',
            'username' => 'rezamobile',
            'email' => 'reza@example.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'bio' => 'Expert Flutter dan React Native.',
            'verification_status' => 'pending',
            'is_active' => true,
        ]);
    }
}
