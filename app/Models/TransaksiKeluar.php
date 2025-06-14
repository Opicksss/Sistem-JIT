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
        'biaya_penyimpanan',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'stok' => 'decimal:3',
        'stok_awal' => 'decimal:3',
        'sisa' => 'decimal:3',
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
   
}