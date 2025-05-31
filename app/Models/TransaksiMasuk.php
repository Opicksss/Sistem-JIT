<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'transaksi_masuks';
    protected $fillable = [
        'id_transaksi',
        'penerima',
        'suplier_id',
        'bahan_baku_id',
        'stok',
        'tanggal_masuk',
    ];

   protected $casts = [
        'tanggal_masuk' => 'date',
        'stok' => 'integer'
    ];

    // Relasi dengan suplier
    public function suplier()
    {
        return $this->belongsTo(Suplier::class);
    }

    // Relasi dengan bahan baku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    // Event ketika transaksi dibuat
    protected static function boot()
    {
        parent::boot();

        // Ketika transaksi masuk dibuat, otomatis tambah stok bahan baku
        static::created(function ($transaksi) {
            $transaksi->bahanBaku->tambahStok($transaksi->stok);
        });

        // Ketika transaksi masuk diupdate, sesuaikan stok
        static::updated(function ($transaksi) {
            if ($transaksi->wasChanged('stok')) {
                $oldStok = $transaksi->getOriginal('stok');
                $newStok = $transaksi->stok;
                $selisih = $newStok - $oldStok;
                
                if ($selisih > 0) {
                    $transaksi->bahanBaku->tambahStok($selisih);
                } else {
                    $transaksi->bahanBaku->kurangiStok(abs($selisih));
                }
            }
        });

        // Ketika transaksi masuk dihapus, kurangi stok
        static::deleted(function ($transaksi) {
            $transaksi->bahanBaku->kurangiStok($transaksi->stok);
        });
    }
}
