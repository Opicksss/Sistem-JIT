<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('bahan_bakus')->insert([
            ['id_bahan_baku' => 'Pcx250', 'nama' => 'Udang Rebon', 'jenis' => 'Pangan', 'satuan' => 'Kg', 'harga' => 10000, 'stok' => 5.396],
            ['id_bahan_baku' => 'Pcx251', 'nama' => 'Garam', 'jenis' => 'Pangan', 'satuan' => 'Kg', 'harga' => 10000, 'stok' => 3.362],
        ]);
    }
}
