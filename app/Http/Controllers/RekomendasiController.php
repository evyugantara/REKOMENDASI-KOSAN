<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\PreferensiUser;
use App\Services\RekomendasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekomendasiController extends Controller
{
    public function __construct(private RekomendasiService $rekomendasiService) {}

    public function index()
    {
        $preferensi = null;
        $hasil = [];

        if (Auth::check()) {
            $preferensi = Auth::user()->preferensi;
        } else {
            $data = session('guest_preferensi');
            if ($data) {
                $preferensi = new PreferensiUser($data);
            }
        }

        if ($preferensi) {
            $hasil = $this->rekomendasiService->rekomendasikan($preferensi);
        }

        return view('rekomendasi.index', compact('preferensi', 'hasil'));
    }

    public function simpanPreferensi(Request $request)
    {
        $request->validate([
            'harga_min' => 'required|integer|min:0',
            'harga_max' => 'required|integer|gt:harga_min',
            'jarak_max' => 'required|numeric|min:0.5|max:20',
            'tipe_kost' => 'nullable|in:putra,putri,campur',
            'min_rating' => 'nullable|numeric|min:0|max:5',
        ], [
            'harga_max.gt' => 'Harga maksimal harus lebih besar dari harga minimal.',
            'jarak_max.min' => 'Jarak maksimal minimal 0.5 km.',
        ]);

        $data = [
            'harga_min' => (int) $request->harga_min,
            'harga_max' => (int) $request->harga_max,
            'jarak_max' => (float) $request->jarak_max,
            'tipe_kost' => $request->tipe_kost,
            'min_rating' => (float) ($request->min_rating ?? 0),
            'butuh_ac' => $request->boolean('butuh_ac'),
            'butuh_wifi' => $request->boolean('butuh_wifi'),
            'butuh_kamar_mandi_dalam' => $request->boolean('butuh_kamar_mandi_dalam'),
            'butuh_parkir_motor' => $request->boolean('butuh_parkir_motor'),
            'butuh_parkir_mobil' => $request->boolean('butuh_parkir_mobil'),
            'butuh_dapur' => $request->boolean('butuh_dapur'),
            'butuh_laundry' => $request->boolean('butuh_laundry'),
        ];

        if (Auth::check()) {
            Auth::user()->preferensi()->updateOrCreate(
                ['user_id' => Auth::id()],
                $data
            );
        } else {
            session(['guest_preferensi' => $data]);
        }

        return redirect()->route('rekomendasi.hasil')->with('success', 'Preferensi berhasil disimpan! Berikut rekomendasi kost untuk Anda.');
    }

    public function hasil()
    {
        if (Auth::check()) {
            $preferensi = Auth::user()->preferensi;
        } else {
            $data = session('guest_preferensi');
            $preferensi = $data ? new PreferensiUser($data) : null;
        }

        if (!$preferensi) {
            return redirect()->route('rekomendasi.index')->with('info', 'Silakan isi preferensi terlebih dahulu.');
        }

        $hasil = $this->rekomendasiService->rekomendasikan($preferensi);

        return view('rekomendasi.hasil', compact('preferensi', 'hasil'));
    }

    public function apiHitung(Request $request)
    {
        $request->validate([
            'harga_min' => 'required|integer',
            'harga_max' => 'required|integer',
            'jarak_max' => 'required|numeric',
            'tipe_kost' => 'nullable|string',
        ]);

        $preferensi = new PreferensiUser($request->all());
        $hasil = $this->rekomendasiService->rekomendasikan($preferensi);

        $data = array_map(fn($item) => [
            'id' => $item['kost']->id,
            'nama' => $item['kost']->nama,
            'harga' => $item['kost']->harga_per_bulan,
            'jarak' => $item['kost']->jarak_kampus,
            'rating' => $item['kost']->rating_rata,
            'skor' => $item['skor'],
            'skor_detail' => [
                'harga' => $item['skor_harga'],
                'fasilitas' => $item['skor_fasilitas'],
                'jarak' => $item['skor_jarak'],
                'rating' => $item['skor_rating'],
            ],
        ], array_slice($hasil, 0, 10));

        return response()->json(['success' => true, 'data' => $data]);
    }
}
