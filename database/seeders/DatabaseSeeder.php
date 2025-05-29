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

        DB::table('bahan_bakus')->insert([
            ['id_bahan_baku' => 'Pcx250', 'nama' => 'Beras', 'jenis' => 'Pangan', 'satuan' => 'Kg', 'harga' => 12000, 'stok' => 100,],
            ['id_bahan_baku' => 'Pcx251', 'nama' => 'Gula', 'jenis' => 'Pangan', 'satuan' => 'Kg', 'harga' => 15000, 'stok' => 50,],
            ['id_bahan_baku' => 'Pcx252', 'nama' => 'Minyak Goreng', 'jenis' => 'Pangan', 'satuan' => 'L', 'harga' => 20000, 'stok' => 30,],
        ]);
        DB::table('supliers')->insert([
            ['id_suplier' => 'Pcx100', 'nama' => 'Supplier A', 'alamat' => 'Jl. Raya No. 1', 'telepon' => '081234567890', 'kota' => 'Kota A', 'provinsi' => 'Provinsi A'],
            ['id_suplier' => 'Pcx101', 'nama' => 'Supplier B', 'alamat' => 'Jl. Raya No. 2', 'telepon' => '081234567891', 'kota' => 'Kota B', 'provinsi' => 'Provinsi B'],
            ['id_suplier' => 'Pcx102', 'nama' => 'Supplier C', 'alamat' => 'Jl. Raya No. 3', 'telepon' => '081234567892', 'kota' => 'Kota C', 'provinsi' => 'Provinsi C'],
        ]);
        DB::table('transaksi_masuks')->insert([
            [
                'id_transaksi' => 'TRX001',
                'penerima' => 'Opik',
                'suplier_id' => 1,
                'bahan_baku_id' => 1,
                'stok' => 50,
                'tanggal_masuk' => now(),
            ],
            [
                'id_transaksi' => 'TRX002',
                'penerima' => 'Opik',
                'suplier_id' => 2,
                'bahan_baku_id' => 2,
                'stok' => 20,
                'tanggal_masuk' => now(),
            ],
        ]);
        DB::table('transaksi_keluars')->insert([
            [
                'id_transaksi' => 'TRX003',
                'penerima' => 'Opik',
                'suplier_id' => 1,
                'bahan_baku_id' => 1,
                'stok' => 30,
                'tanggal_keluar' => now(),
            ],
            [
                'id_transaksi' => 'TRX004',
                'penerima' => 'Opik',
                'suplier_id' => 2,
                'bahan_baku_id' => 2,
                'stok' => 10,
                'tanggal_keluar' => now(),
            ],
        ]);
    }
}
