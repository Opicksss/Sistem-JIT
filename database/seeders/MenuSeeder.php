<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('menus')->insert([
            ['name' => 'bahan_baku', 'label' => 'Bahan Baku'],
            ['name' => 'supplier', 'label' => 'Supplier'],
            ['name' => 'transaksi_masuk', 'label' => 'Transaksi Masuk'],
            ['name' => 'transaksi_keluar', 'label' => 'Transaksi Keluar'],
            ['name' => 'laporan_masuk', 'label' => 'Laporan Masuk'],
            ['name' => 'laporan_keluar', 'label' => 'Laporan Keluar'],
            ['name' => 'grafik_transaksi_masuk', 'label' => 'Grafik Transaksi Masuk'],
            ['name' => 'grafik_transaksi_keluar', 'label' => 'Grafik Transaksi Keluar'],
            ['name' => 'grafik_transaksi', 'label' => 'Grafik Transaksi'],
        ]);
    }
}
