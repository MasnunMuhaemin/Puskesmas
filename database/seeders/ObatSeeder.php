<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            ['nama_obat' => 'Paracetamol 500mg', 'satuan' => 'tablet', 'stok' => 500, 'harga' => 500],
            ['nama_obat' => 'Amoxicillin 500mg', 'satuan' => 'tablet', 'stok' => 200, 'harga' => 1200],
            ['nama_obat' => 'OBH Syrup 100ml', 'satuan' => 'sirup', 'stok' => 50, 'harga' => 15000],
            ['nama_obat' => 'Vitamin C 500mg', 'satuan' => 'tablet', 'stok' => 1000, 'harga' => 800],
            ['nama_obat' => 'Amlodipine 5mg', 'satuan' => 'tablet', 'stok' => 100, 'harga' => 2500],
            ['nama_obat' => 'Salbutamol Nebu', 'satuan' => 'ampul', 'stok' => 30, 'harga' => 10000],
            ['nama_obat' => 'Betadine Salep', 'satuan' => 'salep', 'stok' => 25, 'harga' => 12000],
            ['nama_obat' => 'Ceterizine 10mg', 'satuan' => 'tablet', 'stok' => 150, 'harga' => 3000],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
