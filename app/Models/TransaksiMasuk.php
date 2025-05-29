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

    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'suplier_id');
    }
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
