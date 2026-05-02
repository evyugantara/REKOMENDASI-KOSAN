<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, Kost $kost)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        // Cek apakah sudah pernah ulasan
        $existing = Ulasan::where('kost_id', $kost->id)->where('user_id', Auth::id())->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk kost ini.');
        }

        Ulasan::create([
            'kost_id' => $kost->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'is_approved' => true,
        ]);

        // Update rata-rata rating
        $this->updateRatingKost($kost);

        return back()->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }

    public function destroy(Ulasan $ulasan)
    {
        if ($ulasan->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $kost = $ulasan->kost;
        $ulasan->delete();
        $this->updateRatingKost($kost);

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    private function updateRatingKost(Kost $kost): void
    {
        $ulasans = Ulasan::where('kost_id', $kost->id)->where('is_approved', true)->get();
        $rata = $ulasans->count() > 0 ? $ulasans->avg('rating') : 0;
        $kost->update([
            'rating_rata' => round($rata, 2),
            'jumlah_ulasan' => $ulasans->count(),
        ]);
    }
}
