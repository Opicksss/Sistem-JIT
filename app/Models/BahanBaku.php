<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_bakus';

    protected $fillable = [
        'id_bahan_baku',
        'nama',
        'jenis',
        'satuan',
        'harga',
        'stok',
        'gambar',
    ];

    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasuk::class, 'bahan_baku_id');
    }
    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluar::class, 'bahan_baku_id');
    }
}
