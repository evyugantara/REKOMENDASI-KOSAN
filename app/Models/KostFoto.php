<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KostFoto extends Model
{
    protected $fillable = ['kost_id', 'foto', 'keterangan', 'urutan'];

    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->foto);
    }
}
