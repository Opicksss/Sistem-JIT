<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_bahan_baku',
        'nama',
        'jenis',
        'gambar',
        'satuan',
        'harga',
        'stok'
    ];


    public function transaksiMasuks()
    {
        return $this->hasMany(TransaksiMasuk::class);
    }

    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasuk::class, 'bahan_baku_id');
    }

    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluar::class, 'bahan_baku_id');
    }



    public function tambahStok($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah penambahan stok harus lebih dari 0');
        }

        $this->increment('stok', $jumlah);
        $this->save();
        return true;
    }

    public function kurangiStok($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah pengurangan stok harus lebih dari 0');
        }

        $this->refresh();

        if ($this->stok >= $jumlah) {
            $this->decrement('stok', $jumlah);
            $this->save();
            return true;
        }

        return false;
    }


    public function getStokTerbaru()
    {
        return $this->fresh()->stok;
    }
}
