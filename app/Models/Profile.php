<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['id_akun', 'alamat', 'telepon'];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
