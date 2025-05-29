<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Menu;
use App\Models\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_users');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function hasMenuAccess($routeName)
    {
        // Admin bisa akses semua
        if ($this->role === 'admin') {
            return true;
        }

        // Pegawai hanya bisa akses menu yang punya relasi
        return $this->menus()->where('name', $routeName)->exists();
    }
}
