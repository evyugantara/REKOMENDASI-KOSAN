<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreferensiUser extends Model
{
    protected $fillable = [
        'user_id', 'harga_min', 'harga_max', 'jarak_max', 'tipe_kost',
        'min_rating', 'butuh_ac', 'butuh_wifi', 'butuh_kamar_mandi_dalam',
        'butuh_parkir_motor', 'butuh_parkir_mobil', 'butuh_dapur', 'butuh_laundry',
    ];

    protected $casts = [
        'butuh_ac' => 'boolean',
        'butuh_wifi' => 'boolean',
        'butuh_kamar_mandi_dalam' => 'boolean',
        'butuh_parkir_motor' => 'boolean',
        'butuh_parkir_mobil' => 'boolean',
        'butuh_dapur' => 'boolean',
        'butuh_laundry' => 'boolean',
        'jarak_max' => 'float',
        'min_rating' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFasilitasPreferensiVector(): array
    {
        return [
            (int) $this->butuh_ac,
            (int) $this->butuh_wifi,
            (int) $this->butuh_kamar_mandi_dalam,
            0, // lemari - not in preference
            0, // kasur - not in preference
            0, // meja kursi - not in preference
            (int) $this->butuh_parkir_motor,
            (int) $this->butuh_parkir_mobil,
            (int) $this->butuh_dapur,
            (int) $this->butuh_laundry,
            0, // cctv
            0, // mushola
        ];
    }
}
