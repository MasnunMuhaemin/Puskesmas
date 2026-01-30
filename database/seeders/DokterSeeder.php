<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dokter::create([
            'nama' => 'Dr. Andi',
            'spesialis' => 'Umum',
            'poli_id' => 1
        ]);
    }
}
