<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pasien::create([
            'nama' => 'Budi',
            'nik' => '3201112233440001',
            'alamat' => 'Bandung',
            'tanggal_lahir' => '1999-05-10'
        ]);
    }
}
