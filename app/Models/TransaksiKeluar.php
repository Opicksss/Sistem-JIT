<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi',
        'penerima',
        'suplier_id',
        'bahan_baku_id',
        'stok',
        'tanggal_keluar',
        'stok_awal',
        'sisa',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
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

    // Event ketika transaksi dibuat, diupdate, atau dihapus
    protected static function boot()
    {
        parent::boot();

        // Ketika transaksi keluar dibuat, otomatis kurangi stok bahan baku
        static::creating(function ($transaksi) {
            // Validasi stok sebelum membuat transaksi
            $bahanBaku = BahanBaku::find($transaksi->bahan_baku_id);
            if (!$bahanBaku) {
                throw new \Exception('Bahan baku tidak ditemukan');
            }

            if ($bahanBaku->stok < $transaksi->stok) {
                throw new \Exception("Stok {$bahanBaku->nama} tidak mencukupi! Stok tersedia: {$bahanBaku->stok}, diminta: {$transaksi->stok}");
            }
        });

        static::created(function ($transaksi) {
            // Kurangi stok bahan baku
            $transaksi->bahanBaku->kurangiStok($transaksi->stok);
        });

        // Ketika transaksi keluar diupdate, sesuaikan stok
        static::updating(function ($transaksi) {
            if ($transaksi->wasChanged('stok')) {
                $oldStok = $transaksi->getOriginal('stok');
                $newStok = $transaksi->stok;
                $selisih = $newStok - $oldStok;

                // Jika stok bertambah, kurangi stok bahan baku lebih banyak
                if ($selisih > 0) {
                    // Cek apakah stok bahan baku cukup
                    if ($transaksi->bahanBaku->stok < $selisih) {
                        throw new \Exception("Stok {$transaksi->bahanBaku->nama} tidak mencukupi untuk update!");
                    }
                    $transaksi->bahanBaku->kurangiStok($selisih);
                }
                // Jika stok berkurang, kembalikan stok bahan baku
                else {
                    $transaksi->bahanBaku->tambahStok(abs($selisih));
                }
            }
        });

        // Ketika transaksi keluar dihapus, kembalikan stok
        static::deleted(function ($transaksi) {
            $transaksi->bahanBaku->tambahStok($transaksi->stok);
        });
    }
}
