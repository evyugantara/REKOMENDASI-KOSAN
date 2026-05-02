<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\KostFoto;
use App\Models\User;
use App\Models\Ulasan;
use App\Services\RekomendasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKostController extends Controller
{
    public function __construct(private RekomendasiService $rekomendasiService) {}

    public function dashboard()
    {
        $stats = [
            'total_kost' => Kost::count(),
            'kost_aktif' => Kost::active()->count(),
            'total_user' => User::where('role', 'mahasiswa')->count(),
            'total_ulasan' => Ulasan::count(),
            'total_pemilik' => User::where('role', 'pemilik')->count(),
        ];

        $kostTerbaru = Kost::orderBy('created_at', 'desc')->limit(5)->get();
        $ulasanTerbaru = Ulasan::with(['user', 'kost'])->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'kostTerbaru', 'ulasanTerbaru'));
    }

    public function index()
    {
        $kosts = Kost::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.kost.index', compact('kosts'));
    }

    public function create()
    {
        return view('admin.kost.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'harga_per_bulan' => 'required|integer|min:0',
            'tipe' => 'required|in:putra,putri,campur',
            'jumlah_kamar' => 'required|integer|min:1',
            'kamar_tersedia' => 'required|integer|min:0',
            'no_whatsapp' => 'required|string|max:20',
            'pemilik' => 'required|string|max:100',
            'foto_utama' => 'nullable|image|max:2048',
            'fotos.*' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_utama')) {
            $validated['foto_utama'] = $request->file('foto_utama')->store('kost', 'public');
        }

        // Fasilitas checkboxes
        foreach ($this->fasilitasFields() as $field) {
            $validated[$field] = $request->boolean($field);
        }

        $kost = Kost::create($validated);

        // Update jarak kampus
        $jarak = $this->rekomendasiService->haversineDistance(
            RekomendasiService::KAMPUS_LAT, RekomendasiService::KAMPUS_LNG,
            $kost->latitude, $kost->longitude
        );
        $kost->update(['jarak_kampus' => $jarak]);

        // Upload multiple photos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $i => $foto) {
                $path = $foto->store('kost/galeri', 'public');
                KostFoto::create(['kost_id' => $kost->id, 'foto' => $path, 'urutan' => $i]);
            }
        }

        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil ditambahkan!');
    }

    public function edit(Kost $kost)
    {
        $kost->load('fotos');
        return view('admin.kost.edit', compact('kost'));
    }

    public function update(Request $request, Kost $kost)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'harga_per_bulan' => 'required|integer|min:0',
            'tipe' => 'required|in:putra,putri,campur',
            'jumlah_kamar' => 'required|integer|min:1',
            'kamar_tersedia' => 'required|integer|min:0',
            'no_whatsapp' => 'required|string|max:20',
            'pemilik' => 'required|string|max:100',
            'foto_utama' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_utama')) {
            if ($kost->foto_utama) {
                Storage::disk('public')->delete($kost->foto_utama);
            }
            $validated['foto_utama'] = $request->file('foto_utama')->store('kost', 'public');
        }

        foreach ($this->fasilitasFields() as $field) {
            $validated[$field] = $request->boolean($field);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $kost->update($validated);

        // Update jarak
        $jarak = $this->rekomendasiService->haversineDistance(
            RekomendasiService::KAMPUS_LAT, RekomendasiService::KAMPUS_LNG,
            $kost->latitude, $kost->longitude
        );
        $kost->update(['jarak_kampus' => $jarak]);

        // Upload additional photos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $i => $foto) {
                $path = $foto->store('kost/galeri', 'public');
                $lastUrutan = KostFoto::where('kost_id', $kost->id)->max('urutan') ?? -1;
                KostFoto::create(['kost_id' => $kost->id, 'foto' => $path, 'urutan' => $lastUrutan + 1 + $i]);
            }
        }

        return redirect()->route('admin.kost.index')->with('success', 'Data kost berhasil diperbarui!');
    }

    public function destroy(Kost $kost)
    {
        if ($kost->foto_utama) {
            Storage::disk('public')->delete($kost->foto_utama);
        }
        foreach ($kost->fotos as $foto) {
            Storage::disk('public')->delete($foto->foto);
        }
        $kost->delete();

        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil dihapus!');
    }

    public function hapusFoto(KostFoto $foto)
    {
        Storage::disk('public')->delete($foto->foto);
        $foto->delete();
        return back()->with('success', 'Foto berhasil dihapus!');
    }

    public function manageUsers()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function manageUlasan()
    {
        $ulasans = Ulasan::with(['user', 'kost'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.ulasan', compact('ulasans'));
    }

    public function approveUlasan(Ulasan $ulasan)
    {
        $ulasan->update(['is_approved' => !$ulasan->is_approved]);
        return back()->with('success', 'Status ulasan diperbarui!');
    }

    private function fasilitasFields(): array
    {
        return [
            'fasilitas_ac', 'fasilitas_wifi', 'fasilitas_kamar_mandi_dalam',
            'fasilitas_lemari', 'fasilitas_kasur', 'fasilitas_meja_kursi',
            'fasilitas_parkir_motor', 'fasilitas_parkir_mobil', 'fasilitas_dapur',
            'fasilitas_laundry', 'fasilitas_cctv', 'fasilitas_mushola',
        ];
    }
}
