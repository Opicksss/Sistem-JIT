<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'satuan',
        'harga',
        'stok'
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

    // Method untuk menambah stok dengan validasi
    public function tambahStok($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah penambahan stok harus lebih dari 0');
        }
        
        $this->increment('stok', $jumlah);
        $this->save(); // Pastikan perubahan tersimpan
        return true;
    }

    // Method untuk mengurangi stok dengan validasi yang lebih ketat
    public function kurangiStok($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah pengurangan stok harus lebih dari 0');
        }

        // Refresh data dari database untuk memastikan stok terbaru
        $this->refresh();

        if ($this->stok >= $jumlah) {
            $this->decrement('stok', $jumlah);
            $this->save(); // Pastikan perubahan tersimpan
            return true;
        }
        
        return false;
    }

    // Method untuk mendapatkan stok real-time
    public function getStokTerbaru()
    {
        return $this->fresh()->stok;
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