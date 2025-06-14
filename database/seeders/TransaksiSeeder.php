<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Transaksi Masuk
        $transaksiMasukDataUdang = [
            ['2024-01-01', 14.000, 140000],
            ['2024-01-02', 14.000, 140000],

            ['2024-02-01', 13.000, 130000],

            ['2024-03-01', 5.000, 50000],
            ['2024-03-02', 5.000, 50000],

            ['2024-04-01', 1.000, 10000],
            ['2024-04-02', 10.000, 100000],

            ['2024-05-01', 14.000, 140000],
            ['2024-05-02', 14.000, 140000],

            ['2024-06-01', 5.000, 50000],
            ['2024-06-02', 5.000, 50000],

            ['2024-07-01', 10.000, 100000],
            ['2024-08-01', 20.000, 200000],
            ['2024-09-01', 20.000, 200000],
            ['2024-10-01', 18.000, 180000],


            ['2024-11-01', 10.000, 100000],
            ['2024-11-02', 10.000, 100000],

            ['2024-12-01', 20.000, 200000],
        ];

        foreach ($transaksiMasukDataUdang as $data) {
            DB::table('transaksi_masuks')->insert([
                'id_transaksi' => 'TM-' . Str::random(10),
                'penerima' => 'admin',
                'suplier_id' => 1,
                'bahan_baku_id' => 1,
                'stok' => $data[1],
                'tanggal_masuk' => $data[0],
                'biaya_pemesanan' => $data[2], // Asumsi biaya_pemesanan awalnya 0
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Data Transaksi Keluar
        $transaksiKeluarDataUdang = [
            ['2024-01-01', 20.000, 8.000, 40000],
            ['2024-02-01', 11.452, 9.548, 47740],
            ['2024-03-01', 12.123, 7.425, 37125],
            ['2024-04-01', 10.000, 8.425, 42125],
            ['2024-05-01', 20.111, 16.314, 81570],
            ['2024-06-01', 13.051, 13.263, 66315],
            ['2024-07-01', 15.000, 8.263, 41315],
            ['2024-08-01', 10.000, 18.263, 91315],
            ['2024-09-01', 27.867, 10.396, 51980],
            ['2024-10-01', 19.000, 9.396, 46980],
            ['2024-11-01', 25.000, 4.396, 21980],
            ['2024-12-01', 19.000, 5.396, 26980],
        ];

        foreach ($transaksiKeluarDataUdang as $data) {
            DB::table('transaksi_keluars')->insert([
                'id_transaksi' => 'TK-' . Str::random(10),
                'penerima' => 'admin',
                'bahan_baku_id' => 1,
                'suplier_id' => 1,
                'stok' => $data[1],
                'tanggal_keluar' => $data[0],
                'stok_awal' => $data[1] + $data[2], // stok + sisa
                'sisa' => $data[2],
                'biaya_penyimpanan' => $data[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        $transaksiMasukDataGaram = [
            ['2024-01-01', 9.000, 90000], //1
            ['2024-01-02', 9.000, 90000],

            ['2024-02-01', 15.500, 155000], //2

            ['2024-03-01', 7.000, 70000], //3
            ['2024-03-02', 7.000, 70000],

            ['2024-04-01', 7.500, 75000], //4
            ['2024-04-02', 7.500, 75000],

            ['2024-05-01', 7.000, 70000], //5
            ['2024-05-02', 7.000, 70000],

            ['2024-06-01', 7.500, 75000], //6
            ['2024-06-02', 7.500, 75000],

            ['2024-07-01', 11.000, 110000], //7


            ['2024-08-01', 20.000, 200000], //8

            ['2024-09-01', 14.000, 140000], //9

            ['2024-10-01', 20.000, 200000], //10

            ['2024-11-01', 7.000, 70000], //11
            ['2024-11-02', 7.000, 70000],

            ['2024-12-01', 16.000, 160000], //12
        ];

        foreach ($transaksiMasukDataGaram as $data) {
            DB::table('transaksi_masuks')->insert([
                'id_transaksi' => 'TMA-' . Str::random(10),
                'penerima' => 'admin',
                'suplier_id' => 2,
                'bahan_baku_id' => 2,
                'stok' => $data[1],
                'tanggal_masuk' => $data[0],
                'biaya_pemesanan' => $data[2], // Asumsi biaya_pemesanan awalnya 0
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Data Transaksi Keluar
        $transaksiKeluarDataGaram = [
            ['2024-01-21', 14.000, 4.000, 20000],
            ['2024-02-21', 15.555, 3.945, 19725],
            ['2024-03-21', 15.000, 2.945, 14725],
            ['2024-04-21', 14.765, 3.18, 15900],
            ['2024-05-21', 14.500, 2.68, 13400],
            ['2024-06-21', 15.500, 2.18, 10900],
            ['2024-07-21', 11.000, 2.18, 10900],
            ['2024-08-21', 19.600, 2.58, 12900],
            ['2024-09-21', 14.000, 2.58, 12900],
            ['2024-10-21', 20.000, 2.58, 12900],
            ['2024-11-21', 13.543, 3.037, 15185],
            ['2024-12-21', 15.675, 3.362, 16810],
        ];

        foreach ($transaksiKeluarDataGaram as $data) {
            DB::table('transaksi_keluars')->insert([
                'id_transaksi' => 'TK-' . Str::random(10),
                'penerima' => 'admin',
                'bahan_baku_id' => 2,
                'suplier_id' => 2,
                'stok' => $data[1],
                'tanggal_keluar' => $data[0],
                'stok_awal' => $data[1] + $data[2], // stok + sisa
                'sisa' => $data[2],
                'biaya_penyimpanan' => $data[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}
