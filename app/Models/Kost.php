<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kost extends Model
{
    protected $fillable = [
        'nama', 'deskripsi', 'alamat', 'kelurahan', 'kecamatan',
        'latitude', 'longitude', 'harga_per_bulan', 'tipe',
        'jumlah_kamar', 'kamar_tersedia', 'no_whatsapp', 'pemilik',
        'foto_utama', 'fasilitas_ac', 'fasilitas_wifi',
        'fasilitas_kamar_mandi_dalam', 'fasilitas_lemari', 'fasilitas_kasur',
        'fasilitas_meja_kursi', 'fasilitas_parkir_motor', 'fasilitas_parkir_mobil',
        'fasilitas_dapur', 'fasilitas_laundry', 'fasilitas_cctv',
        'fasilitas_mushola', 'rating_rata', 'jumlah_ulasan', 'jarak_kampus',
        'is_active', 'user_id',
    ];

    protected $casts = [
        'fasilitas_ac' => 'boolean',
        'fasilitas_wifi' => 'boolean',
        'fasilitas_kamar_mandi_dalam' => 'boolean',
        'fasilitas_lemari' => 'boolean',
        'fasilitas_kasur' => 'boolean',
        'fasilitas_meja_kursi' => 'boolean',
        'fasilitas_parkir_motor' => 'boolean',
        'fasilitas_parkir_mobil' => 'boolean',
        'fasilitas_dapur' => 'boolean',
        'fasilitas_laundry' => 'boolean',
        'fasilitas_cctv' => 'boolean',
        'fasilitas_mushola' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'rating_rata' => 'float',
        'jarak_kampus' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(KostFoto::class)->orderBy('urutan');
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }

    public function getFasilitasList(): array
    {
        $fasilitas = [];
        if ($this->fasilitas_ac) $fasilitas[] = ['icon' => 'fa-wind', 'nama' => 'AC'];
        if ($this->fasilitas_wifi) $fasilitas[] = ['icon' => 'fa-wifi', 'nama' => 'WiFi'];
        if ($this->fasilitas_kamar_mandi_dalam) $fasilitas[] = ['icon' => 'fa-shower', 'nama' => 'KM Dalam'];
        if ($this->fasilitas_lemari) $fasilitas[] = ['icon' => 'fa-box', 'nama' => 'Lemari'];
        if ($this->fasilitas_kasur) $fasilitas[] = ['icon' => 'fa-bed', 'nama' => 'Kasur'];
        if ($this->fasilitas_meja_kursi) $fasilitas[] = ['icon' => 'fa-chair', 'nama' => 'Meja & Kursi'];
        if ($this->fasilitas_parkir_motor) $fasilitas[] = ['icon' => 'fa-motorcycle', 'nama' => 'Parkir Motor'];
        if ($this->fasilitas_parkir_mobil) $fasilitas[] = ['icon' => 'fa-car', 'nama' => 'Parkir Mobil'];
        if ($this->fasilitas_dapur) $fasilitas[] = ['icon' => 'fa-utensils', 'nama' => 'Dapur'];
        if ($this->fasilitas_laundry) $fasilitas[] = ['icon' => 'fa-soap', 'nama' => 'Laundry'];
        if ($this->fasilitas_cctv) $fasilitas[] = ['icon' => 'fa-video', 'nama' => 'CCTV'];
        if ($this->fasilitas_mushola) $fasilitas[] = ['icon' => 'fa-mosque', 'nama' => 'Mushola'];
        return $fasilitas;
    }

    public function getTipeLabel(): string
    {
        return match($this->tipe) {
            'putra' => 'Putra',
            'putri' => 'Putri',
            'campur' => 'Campur',
            default => '-',
        };
    }

    public function getHargaFormatted(): string
    {
        return 'Rp ' . number_format($this->harga_per_bulan, 0, ',', '.');
    }

    public function getJarakFormatted(): string
    {
        if ($this->jarak_kampus === null) return '-';
        if ($this->jarak_kampus < 1) {
            return round($this->jarak_kampus * 1000) . ' m';
        }
        return number_format($this->jarak_kampus, 1) . ' km';
    }

    public function getFotoUtamaUrl(): string
    {
        if ($this->foto_utama) {
            return asset('storage/' . $this->foto_utama);
        }
        return asset('images/kost-default.jpg');
    }

    public function getFasilitasVector(): array
    {
        return [
            (int) $this->fasilitas_ac,
            (int) $this->fasilitas_wifi,
            (int) $this->fasilitas_kamar_mandi_dalam,
            (int) $this->fasilitas_lemari,
            (int) $this->fasilitas_kasur,
            (int) $this->fasilitas_meja_kursi,
            (int) $this->fasilitas_parkir_motor,
            (int) $this->fasilitas_parkir_mobil,
            (int) $this->fasilitas_dapur,
            (int) $this->fasilitas_laundry,
            (int) $this->fasilitas_cctv,
            (int) $this->fasilitas_mushola,
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFiltered($query, array $filters)
    {
        if (!empty($filters['harga_min'])) {
            $query->where('harga_per_bulan', '>=', $filters['harga_min']);
        }
        if (!empty($filters['harga_max'])) {
            $query->where('harga_per_bulan', '<=', $filters['harga_max']);
        }
        if (!empty($filters['tipe'])) {
            $query->where('tipe', $filters['tipe']);
        }
        if (!empty($filters['jarak_max'])) {
            $query->where('jarak_kampus', '<=', $filters['jarak_max']);
        }
        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('nama', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('alamat', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('kecamatan', 'like', '%' . $filters['search'] . '%');
            });
        }
        return $query;
    }
}
