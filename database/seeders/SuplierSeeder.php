<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('supliers')->insert([
            ['id_suplier' => 'Pcx100', 'nama' => 'Supplier A', 'alamat' => 'Jl. Raya No. 1', 'telepon' => '081234567890', 'kota' => 'Kota A', 'provinsi' => 'Provinsi A'],
            ['id_suplier' => 'Pcx101', 'nama' => 'Supplier B', 'alamat' => 'Jl. Raya No. 2', 'telepon' => '081234567891', 'kota' => 'Kota B', 'provinsi' => 'Provinsi B'],
            ['id_suplier' => 'Pcx102', 'nama' => 'Supplier C', 'alamat' => 'Jl. Raya No. 3', 'telepon' => '081234567892', 'kota' => 'Kota C', 'provinsi' => 'Provinsi C'],
        ]);
    }
}
