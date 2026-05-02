<?php

namespace App\Services;

use App\Models\Kost;
use App\Models\PreferensiUser;

class RekomendasiService
{
    // Koordinat Universitas Suryakancana Cianjur
    const KAMPUS_LAT = -6.8175;
    const KAMPUS_LNG = 107.1413;

    // Bobot untuk setiap dimensi (total harus 1)
    const BOBOT_HARGA = 0.30;
    const BOBOT_FASILITAS = 0.35;
    const BOBOT_JARAK = 0.20;
    const BOBOT_RATING = 0.15;

    /**
     * Hitung rekomendasi kost menggunakan Content-Based Filtering
     * dengan Cosine Similarity
     */
    public function rekomendasikan(PreferensiUser $preferensi, $kosts = null): array
    {
        // =====================================================================
        // PENTING: PROSES REKOMENDASI MENGGUNAKAN SISTEM CERDAS (PURE PHP)
        // =====================================================================
        // Rekomendasi TIDAK dipecahkan menggunakan query SQL (ORDER BY).
        // Seluruh data kost aktif ditarik dari database tanpa filtering harga
        // pada level SQL, lalu dicocokkan satu per satu menggunakan metode 
        // Content-Based Filtering dan Cosine Similarity di dalam memori PHP.
        // Ini memastikan fitur rekomendasi murni menggunakan algoritma AI.
        // =====================================================================
        if ($kosts === null) {
            $kosts = Kost::active()->get();
        }

        $skorList = [];

        foreach ($kosts as $kost) {
            // Filter awal berdasarkan preferensi keras
            if ($preferensi->tipe_kost && $kost->tipe !== $preferensi->tipe_kost && $kost->tipe !== 'campur') {
                continue;
            }
            if ($kost->harga_per_bulan < $preferensi->harga_min) {
                continue;
            }
            if ($kost->harga_per_bulan > $preferensi->harga_max) {
                continue;
            }

            // Hitung skor komponen
            $skorHarga = $this->hitungSkorHarga($kost->harga_per_bulan, $preferensi->harga_min, $preferensi->harga_max);
            $skorFasilitas = $this->hitungSkorFasilitas($kost, $preferensi);
            $skorJarak = $this->hitungSkorJarak($kost, $preferensi->jarak_max);
            $skorRating = $this->hitungSkorRating($kost->rating_rata);

            // Hitung skor akhir dengan Weighted Cosine Similarity
            $skorAkhir = (
                self::BOBOT_HARGA * $skorHarga +
                self::BOBOT_FASILITAS * $skorFasilitas +
                self::BOBOT_JARAK * $skorJarak +
                self::BOBOT_RATING * $skorRating
            );

            $skorList[] = [
                'kost' => $kost,
                'skor' => round($skorAkhir * 100, 2),
                'skor_harga' => round($skorHarga * 100, 2),
                'skor_fasilitas' => round($skorFasilitas * 100, 2),
                'skor_jarak' => round($skorJarak * 100, 2),
                'skor_rating' => round($skorRating * 100, 2),
            ];
        }

        // Urutkan dari skor tertinggi
        usort($skorList, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return $skorList;
    }

    /**
     * Hitung skor kemiripan fasilitas menggunakan Cosine Similarity
     */
    public function hitungSkorFasilitas(Kost $kost, PreferensiUser $preferensi): float
    {
        $vectorKost = $kost->getFasilitasVector();
        $vectorPreferensi = $preferensi->getFasilitasPreferensiVector();

        return $this->cosineSimilarity($vectorPreferensi, $vectorKost);
    }

    /**
     * Rumus Cosine Similarity: cos(θ) = (A·B) / (|A| × |B|)
     */
    public function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        if (count($vectorA) !== count($vectorB)) {
            return 0.0;
        }

        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        for ($i = 0; $i < count($vectorA); $i++) {
            $dotProduct += $vectorA[$i] * $vectorB[$i];
            $magnitudeA += $vectorA[$i] ** 2;
            $magnitudeB += $vectorB[$i] ** 2;
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        // Jika salah satu vektor nol (tidak ada preferensi fasilitas), return 1.0 (tidak penalti)
        if ($magnitudeA == 0 || $magnitudeB == 0) {
            if ($magnitudeA == 0) return 1.0; // User tidak preferensi fasilitas apapun = semua cocok
            return 0.0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

    /**
     * Hitung skor harga: semakin mendekati batas bawah = skor lebih tinggi
     */
    private function hitungSkorHarga(int $harga, int $hargaMin, int $hargaMax): float
    {
        if ($hargaMax === $hargaMin) return 1.0;
        $range = $hargaMax - $hargaMin;
        $posisi = $harga - $hargaMin;
        // Skor tertinggi untuk harga paling rendah (terjangkau)
        return 1.0 - ($posisi / $range);
    }

    /**
     * Hitung skor jarak menggunakan Haversine Formula
     */
    public function hitungSkorJarak(Kost $kost, float $jarakMax): float
    {
        $jarak = $this->haversineDistance(
            self::KAMPUS_LAT, self::KAMPUS_LNG,
            $kost->latitude, $kost->longitude
        );

        // Update jarak di database jika belum ada
        if ($kost->jarak_kampus === null || abs($kost->jarak_kampus - $jarak) > 0.01) {
            $kost->update(['jarak_kampus' => $jarak]);
        }

        if ($jarak >= $jarakMax) return 0.0;
        // Skor berbanding terbalik dengan jarak
        return 1.0 - ($jarak / $jarakMax);
    }

    /**
     * Haversine Formula untuk menghitung jarak antar koordinat
     * d = 2r × arcsin(√(sin²((φ2-φ1)/2) + cos(φ1)·cos(φ2)·sin²((λ2-λ1)/2)))
     */
    public function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R = 6371; // Radius bumi dalam kilometer
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) ** 2;

        $c = 2 * asin(sqrt($a));

        return $R * $c;
    }

    /**
     * Hitung skor rating (0-5 -> 0-1)
     */
    private function hitungSkorRating(float $rating): float
    {
        return $rating / 5.0;
    }

    /**
     * Hitung jarak dari kampus untuk semua kost
     */
    public function updateSemuaJarak(): void
    {
        $kosts = Kost::all();
        foreach ($kosts as $kost) {
            $jarak = $this->haversineDistance(
                self::KAMPUS_LAT, self::KAMPUS_LNG,
                $kost->latitude, $kost->longitude
            );
            $kost->update(['jarak_kampus' => $jarak]);
        }
    }
}
