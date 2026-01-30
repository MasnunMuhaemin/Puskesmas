<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Dokter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data Dokter untuk referensi rekam medis
        $dokter = Dokter::first();
        if (!$dokter) {
            $dokter = Dokter::create([
                'nama' => 'Dr. Andi Pratama',
                'spesialis' => 'Umum',
                'poli_id' => 1
            ]);
        }

        $dataPasien = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'nik' => '3171010101010001',
                'alamat' => 'Jl. Kebon Jeruk No. 12, Jakarta',
                'tanggal_lahir' => '1995-08-20',
                'riwayat' => [
                    [
                        'keluhan' => 'Demam tinggi dan pusing',
                        'diagnosa' => 'Influenza',
                        'tindakan' => 'Istirahat dan Paracetamol',
                        'tanggal' => Carbon::now()->subMonths(1)
                    ],
                    [
                        'keluhan' => 'Batuk berdahak',
                        'diagnosa' => 'ISPA',
                        'tindakan' => 'Sirup obat batuk',
                        'tanggal' => Carbon::now()->subDays(10)
                    ]
                ]
            ],
            [
                'name' => 'Ani Wijaya',
                'email' => 'ani@gmail.com',
                'nik' => '3171010101010002',
                'alamat' => 'Jl. Mawar No. 5, Bandung',
                'tanggal_lahir' => '1998-12-15',
                'riwayat' => [
                    [
                        'keluhan' => 'Sakit perut sebelah kanan',
                        'diagnosa' => 'Maag Akut',
                        'tindakan' => 'Antasida dan diet lunak',
                        'tanggal' => Carbon::now()->subDays(15)
                    ]
                ]
            ],
            [
                'name' => 'Citra Lestari',
                'email' => 'citra@gmail.com',
                'nik' => '3171010101010003',
                'alamat' => 'Jl. Melati No. 8, Surabaya',
                'tanggal_lahir' => '1992-03-25',
                'riwayat' => [
                    [
                        'keluhan' => 'Nyeri sendi lutut',
                        'diagnosa' => 'Asam Urat',
                        'tindakan' => 'Hindari emping/jeroan, obat pereda nyeri',
                        'tanggal' => Carbon::now()->subMonths(2)
                    ]
                ]
            ]
        ];

        foreach ($dataPasien as $item) {
            // Buat User Login
            User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => Hash::make('password'),
                'role' => 'pasien',
                'nik' => $item['nik'],
            ]);

            // Buat Profile Pasien
            $pasien = Pasien::create([
                'nama' => $item['name'],
                'nik' => $item['nik'],
                'alamat' => $item['alamat'],
                'tanggal_lahir' => $item['tanggal_lahir'],
            ]);

            // Buat Rekam Medis
            foreach ($item['riwayat'] as $history) {
                RekamMedis::create([
                    'pasien_id' => $pasien->id,
                    'dokter_id' => $dokter->id,
                    'keluhan' => $history['keluhan'],
                    'diagnosa' => $history['diagnosa'],
                    'tindakan' => $history['tindakan'],
                    'tanggal_periksa' => $history['tanggal'],
                ]);
            }
        }
    }
}
