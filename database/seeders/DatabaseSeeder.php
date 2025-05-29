<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'opik',
            'email' => 'trahman.student@unibamadura.ac.id',
            'password' => Hash::make('123123123'),
            'role' => 'pegawai',
        ]);

        DB::table('menus')->insert([
        ['name' => 'bahan_baku', 'label' => 'Bahan Baku'],
        ['name' => 'supplier', 'label' => 'Supplier'],
        ['name' => 'transaksi_masuk', 'label' => 'Transaksi Masuk'],
        ['name' => 'transaksi_keluar', 'label' => 'Transaksi Keluar'],
        ['name' => 'laporan_masuk', 'label' => 'Laporan Masuk'],
        ['name' => 'laporan_keluar', 'label' => 'Laporan Keluar'],
        ['name' => 'grafik_transaksi_masuk', 'label' => 'Grafik Transaksi Masuk'],
        ['name' => 'grafik_transaksi_keluar', 'label' => 'Grafik Transaksi Keluar'],
        ]);
    }
}
