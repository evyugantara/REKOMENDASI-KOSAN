<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'npm', 'phone', 'avatar', 'role', 'prodi', 'email', 'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kosts(): HasMany
    {
        return $this->hasMany(Kost::class);
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }

    public function preferensi(): HasOne
    {
        return $this->hasOne(PreferensiUser::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
}
