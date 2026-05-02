<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\PreferensiUser;
use App\Services\RekomendasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(private RekomendasiService $rekomendasiService) {}

    public function index(Request $request)
    {
        $kostTerbaru = Kost::active()->orderBy('created_at', 'desc')->limit(4)->get();
        return view('home', compact('kostTerbaru'));
    }

    public function cariKost(Request $request)
    {
        $filters = $request->only(['search', 'harga_min', 'harga_max', 'tipe', 'jarak_max',
            'fasilitas_ac', 'fasilitas_wifi', 'fasilitas_kamar_mandi_dalam',
            'fasilitas_parkir_motor', 'fasilitas_dapur', 'fasilitas_laundry']);

        $query = Kost::active()->with('fotos');

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('nama', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('alamat', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('kecamatan', 'like', '%' . $filters['search'] . '%');
            });
        }
        if (!empty($filters['harga_min'])) {
            $query->where('harga_per_bulan', '>=', (int) $filters['harga_min']);
        }
        if (!empty($filters['harga_max'])) {
            $query->where('harga_per_bulan', '<=', (int) $filters['harga_max']);
        }
        if (!empty($filters['tipe'])) {
            $query->where('tipe', $filters['tipe']);
        }
        if (!empty($filters['jarak_max'])) {
            $query->where('jarak_kampus', '<=', (float) $filters['jarak_max']);
        }
        // Filter fasilitas
        foreach (['fasilitas_ac', 'fasilitas_wifi', 'fasilitas_kamar_mandi_dalam',
                  'fasilitas_parkir_motor', 'fasilitas_dapur', 'fasilitas_laundry'] as $fas) {
            if (!empty($filters[$fas])) {
                $query->where($fas, true);
            }
        }

        $sortBy = $request->get('sort', 'terbaru');
        match($sortBy) {
            'harga_asc' => $query->orderBy('harga_per_bulan', 'asc'),
            'harga_desc' => $query->orderBy('harga_per_bulan', 'desc'),
            'rating' => $query->orderBy('rating_rata', 'desc'),
            'jarak' => $query->orderBy('jarak_kampus', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $kosts = $query->paginate(12)->withQueryString();

        return view('kost.index', compact('kosts', 'filters', 'sortBy'));
    }

    public function detailKost(Kost $kost)
    {
        $kost->load(['fotos', 'ulasans.user']);
        $kostSerupa = Kost::active()
            ->where('id', '!=', $kost->id)
            ->whereBetween('harga_per_bulan', [$kost->harga_per_bulan * 0.7, $kost->harga_per_bulan * 1.3])
            ->where('tipe', $kost->tipe)
            ->limit(4)
            ->get();

        $sudahUlasan = false;
        if (Auth::check()) {
            $sudahUlasan = $kost->ulasans()->where('user_id', Auth::id())->exists();
        }

        return view('kost.detail', compact('kost', 'kostSerupa', 'sudahUlasan'));
    }
}
