<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
            'name' => 'Administrator',
            'email' => 'admin@puskesmas.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas Pendaftaran',
            'email' => 'petugas@puskesmas.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // Dokter
        User::create([
            'name' => 'Dr. Jane Doe',
            'email' => 'dokter@puskesmas.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);
    }
}
