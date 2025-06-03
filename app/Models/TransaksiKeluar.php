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
        'stok' => 'integer',
        'stok_awal' => 'integer',
        'sisa' => 'integer'
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

    // TIDAK ADA EVENT BOOT() - Semua logic stok dihandle di controller
    // Ini untuk menghindari konflik dan memudahkan debugging
}