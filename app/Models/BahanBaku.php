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

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer'
    ];

    // Relasi dengan transaksi masuk
    public function transaksiMasuks()
    {
        return $this->hasMany(TransaksiMasuk::class);
    }

    // Method untuk menambah stok
    public function tambahStok($jumlah)
    {
        $this->increment('stok', $jumlah);
    }

    // Method untuk mengurangi stok
    public function kurangiStok($jumlah)
    {
        if ($this->stok >= $jumlah) {
            $this->decrement('stok', $jumlah);
            return true;
        }
        return false;
    }

    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasuk::class, 'bahan_baku_id');
    }
    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluar::class, 'bahan_baku_id');
    }
}
