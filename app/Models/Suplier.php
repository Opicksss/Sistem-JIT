<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    protected $table = 'supliers';
    protected $fillable = [
        'id_suplier',
        'nama',
        'alamat',
        'telepon',
        'kota',
        'provinsi',
    ];
    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasuk::class, 'suplier_id');
    }
    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluar::class, 'suplier_id');
    }
}
