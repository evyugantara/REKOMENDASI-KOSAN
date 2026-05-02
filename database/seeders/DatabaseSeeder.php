<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kost;
use App\Models\Ulasan;
use App\Services\RekomendasiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rekSvc = new RekomendasiService();

        // Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@kostunsr.ac.id',
            'npm' => null,
            'phone' => '081234567890',
            'role' => 'admin',
            'prodi' => null,
            'password' => Hash::make('admin123'),
        ]);

        // Mahasiswa
        $mhs1 = User::create([
            'name' => 'Ega Virga Yugantara',
            'email' => 'ega@unsur.ac.id',
            'npm' => '5520122034',
            'phone' => '081299990001',
            'role' => 'mahasiswa',
            'prodi' => 'Teknik Informatika',
            'password' => Hash::make('password123'),
        ]);

        $mhs2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@unsur.ac.id',
            'npm' => '5520122010',
            'phone' => '081299990002',
            'role' => 'mahasiswa',
            'prodi' => 'Teknik Informatika',
            'password' => Hash::make('password123'),
        ]);

        $mhs3 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@unsur.ac.id',
            'npm' => '5520122020',
            'phone' => '081299990003',
            'role' => 'mahasiswa',
            'prodi' => 'Manajemen',
            'password' => Hash::make('password123'),
        ]);

        // Data kost sekitar UNSUR Cianjur
        // Koordinat UNSUR: -6.8175, 107.1413
        $kostsData = [
            [
                'nama' => 'Kost Putri Melati Indah',
                'deskripsi' => 'Kost putri eksklusif dekat kampus UNSUR dengan fasilitas lengkap. Lingkungan aman, bersih, dan nyaman. Cocok untuk mahasiswi yang ingin fokus belajar.',
                'alamat' => 'Jl. Pasir Gede Raya No. 12, Cianjur',
                'kelurahan' => 'Muka',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8185,
                'longitude' => 107.1425,
                'harga_per_bulan' => 700000,
                'tipe' => 'putri',
                'jumlah_kamar' => 12,
                'kamar_tersedia' => 4,
                'no_whatsapp' => '082112345601',
                'pemilik' => 'Ibu Sari Wulandari',
                'fasilitas_ac' => false,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => false,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => false,
                'fasilitas_cctv' => true,
                'fasilitas_mushola' => true,
            ],
            [
                'nama' => 'Kost Putra Sejahtera',
                'deskripsi' => 'Kost putra strategis 5 menit dari kampus UNSUR. Kamar luas dengan AC dan WiFi kencang. Penjaga 24 jam untuk keamanan penghuni.',
                'alamat' => 'Jl. Raya Bandung No. 45, Cianjur',
                'kelurahan' => 'Pamoyanan',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8160,
                'longitude' => 107.1390,
                'harga_per_bulan' => 1000000,
                'tipe' => 'putra',
                'jumlah_kamar' => 15,
                'kamar_tersedia' => 3,
                'no_whatsapp' => '082112345602',
                'pemilik' => 'Bapak Hendra Kusuma',
                'fasilitas_ac' => true,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => true,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => false,
                'fasilitas_laundry' => true,
                'fasilitas_cctv' => true,
                'fasilitas_mushola' => false,
            ],
            [
                'nama' => 'Kost Campur Bintang Lima',
                'deskripsi' => 'Kost premium campur dengan fasilitas lengkap. AC, WiFi fiber, kamar mandi dalam, parkir luas. Cocok untuk mahasiswa yang menginginkan kenyamanan maksimal.',
                'alamat' => 'Jl. Taman Sari No. 7, Cianjur',
                'kelurahan' => 'Muka',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8195,
                'longitude' => 107.1430,
                'harga_per_bulan' => 1500000,
                'tipe' => 'campur',
                'jumlah_kamar' => 20,
                'kamar_tersedia' => 5,
                'no_whatsapp' => '082112345603',
                'pemilik' => 'Ibu Dewi Permata',
                'fasilitas_ac' => true,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => true,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => true,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => true,
                'fasilitas_cctv' => true,
                'fasilitas_mushola' => true,
            ],
            [
                'nama' => 'Kost Putri Harapan',
                'deskripsi' => 'Kost putri dengan harga terjangkau, lingkungan bersih dan aman. Dekat warung makan dan minimarket. Ideal untuk mahasiswi dengan anggaran terbatas.',
                'alamat' => 'Jl. Ir. H. Juanda No. 88, Cianjur',
                'kelurahan' => 'Solokpandan',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8200,
                'longitude' => 107.1450,
                'harga_per_bulan' => 500000,
                'tipe' => 'putri',
                'jumlah_kamar' => 10,
                'kamar_tersedia' => 2,
                'no_whatsapp' => '082112345604',
                'pemilik' => 'Ibu Rohana',
                'fasilitas_ac' => false,
                'fasilitas_wifi' => false,
                'fasilitas_kamar_mandi_dalam' => false,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => false,
                'fasilitas_cctv' => false,
                'fasilitas_mushola' => true,
            ],
            [
                'nama' => 'Kost Putra Mandiri',
                'deskripsi' => 'Kost putra dengan fasilitas standar namun layak huni. Lokasi strategis dekat angkutan umum. Kamar cukup luas dengan sirkulasi udara baik.',
                'alamat' => 'Jl. Slamet Riyadi No. 23, Cianjur',
                'kelurahan' => 'Sayang',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8150,
                'longitude' => 107.1380,
                'harga_per_bulan' => 600000,
                'tipe' => 'putra',
                'jumlah_kamar' => 8,
                'kamar_tersedia' => 6,
                'no_whatsapp' => '082112345605',
                'pemilik' => 'Bapak Agus Setiawan',
                'fasilitas_ac' => false,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => false,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => false,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => false,
                'fasilitas_cctv' => false,
                'fasilitas_mushola' => false,
            ],
            [
                'nama' => 'Kost Griya Asri Premium',
                'deskripsi' => 'Hunian premium dengan desain modern. Fasilitas setara apartemen dengan harga kost. Keamanan 24 jam, CCTV di setiap sudut, dan akses kartu pintar.',
                'alamat' => 'Jl. Arief Rahman Hakim No. 15, Cianjur',
                'kelurahan' => 'Muka',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8170,
                'longitude' => 107.1410,
                'harga_per_bulan' => 1800000,
                'tipe' => 'campur',
                'jumlah_kamar' => 25,
                'kamar_tersedia' => 8,
                'no_whatsapp' => '082112345606',
                'pemilik' => 'PT Griya Properti Cianjur',
                'fasilitas_ac' => true,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => true,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => true,
                'fasilitas_dapur' => false,
                'fasilitas_laundry' => true,
                'fasilitas_cctv' => true,
                'fasilitas_mushola' => true,
            ],
            [
                'nama' => 'Kost Putri Kenanga',
                'deskripsi' => 'Kost putri nyaman di kawasan tenang. Ibu kost ramah dan peduli. Cocok untuk mahasiswi yang ingin lingkungan kekeluargaan.',
                'alamat' => 'Jl. Kenanga No. 5, Bojongherang, Cianjur',
                'kelurahan' => 'Bojongherang',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8210,
                'longitude' => 107.1440,
                'harga_per_bulan' => 650000,
                'tipe' => 'putri',
                'jumlah_kamar' => 9,
                'kamar_tersedia' => 3,
                'no_whatsapp' => '082112345607',
                'pemilik' => 'Ibu Yanti Susilawati',
                'fasilitas_ac' => false,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => false,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => true,
                'fasilitas_cctv' => false,
                'fasilitas_mushola' => true,
            ],
            [
                'nama' => 'Kost Putra Executive',
                'deskripsi' => 'Kost putra executive dengan kamar luas ber-AC. Cocok untuk mahasiswa yang membutuhkan ruang belajar yang tenang dan nyaman.',
                'alamat' => 'Jl. Pangeran Hidayatulloh No. 33, Cianjur',
                'kelurahan' => 'Pamoyanan',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8155,
                'longitude' => 107.1395,
                'harga_per_bulan' => 1200000,
                'tipe' => 'putra',
                'jumlah_kamar' => 14,
                'kamar_tersedia' => 2,
                'no_whatsapp' => '082112345608',
                'pemilik' => 'Bapak Rudi Hermanto',
                'fasilitas_ac' => true,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => true,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => false,
                'fasilitas_cctv' => true,
                'fasilitas_mushola' => false,
            ],
            [
                'nama' => 'Kost Murah Berkah',
                'deskripsi' => 'Kost ekonomis untuk mahasiswa dengan anggaran sangat terbatas. Bersih dan aman meskipun fasilitas sederhana.',
                'alamat' => 'Gg. Mawar No. 3, Cianjur',
                'kelurahan' => 'Solokpandan',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8220,
                'longitude' => 107.1460,
                'harga_per_bulan' => 400000,
                'tipe' => 'campur',
                'jumlah_kamar' => 6,
                'kamar_tersedia' => 4,
                'no_whatsapp' => '082112345609',
                'pemilik' => 'Ibu Imas',
                'fasilitas_ac' => false,
                'fasilitas_wifi' => false,
                'fasilitas_kamar_mandi_dalam' => false,
                'fasilitas_lemari' => false,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => false,
                'fasilitas_cctv' => false,
                'fasilitas_mushola' => false,
            ],
            [
                'nama' => 'Kost Putri Flamboyan',
                'deskripsi' => 'Kost putri modern dengan desain minimalis. Kamar dilengkapi AC dan WiFi. Lokasi sangat strategis, hanya 2 menit jalan kaki ke UNSUR.',
                'alamat' => 'Jl. Pasir Gede No. 5A, Cianjur',
                'kelurahan' => 'Muka',
                'kecamatan' => 'Cianjur',
                'latitude' => -6.8178,
                'longitude' => 107.1418,
                'harga_per_bulan' => 900000,
                'tipe' => 'putri',
                'jumlah_kamar' => 18,
                'kamar_tersedia' => 7,
                'no_whatsapp' => '082112345610',
                'pemilik' => 'Ibu Nurul Hidayah',
                'fasilitas_ac' => true,
                'fasilitas_wifi' => true,
                'fasilitas_kamar_mandi_dalam' => false,
                'fasilitas_lemari' => true,
                'fasilitas_kasur' => true,
                'fasilitas_meja_kursi' => true,
                'fasilitas_parkir_motor' => true,
                'fasilitas_parkir_mobil' => false,
                'fasilitas_dapur' => true,
                'fasilitas_laundry' => true,
                'fasilitas_cctv' => true,
                'fasilitas_mushola' => true,
            ],
        ];

        $users = [$mhs1, $mhs2, $mhs3];
        $createdKosts = [];

        foreach ($kostsData as $data) {
            $jarak = $rekSvc->haversineDistance(
                RekomendasiService::KAMPUS_LAT,
                RekomendasiService::KAMPUS_LNG,
                $data['latitude'],
                $data['longitude']
            );
            $data['jarak_kampus'] = $jarak;
            $data['is_active'] = true;
            $createdKosts[] = Kost::create($data);
        }

        // Ulasan sample
        $ulasanData = [
            [0, $mhs1->id, 5, 'Kost sangat bersih dan nyaman. WiFi lancar, ibu kost ramah. Highly recommended!'],
            [0, $mhs2->id, 4, 'Cukup strategis dekat kampus. Harga sesuai kualitas.'],
            [1, $mhs1->id, 5, 'AC dingin, WiFi kencang, kamar mandi dalam. Worth it banget!'],
            [1, $mhs3->id, 4, 'Fasilitas lengkap. Parkir luas. Pemilik kooperatif.'],
            [2, $mhs2->id, 5, 'Kost terbaik yang pernah saya tinggali. Semua fasilitas ada!'],
            [2, $mhs3->id, 5, 'Mewah banget untuk harga segitu. 5 bintang!'],
            [3, $mhs1->id, 3, 'Harga murah fasilitas lumayan. Tidak ada WiFi tapi bersih.'],
            [4, $mhs3->id, 4, 'Kamar luas, pemilik baik. WiFi ada walau agak lambat.'],
            [5, $mhs1->id, 5, 'Premium banget! Seperti tinggal di apartemen.'],
            [6, $mhs2->id, 4, 'Kost putri nyaman, ibu kost baik. Direkomendasikan!'],
            [7, $mhs3->id, 5, 'Kamar AC, KM dalam, lokasi dekat kampus. Sempurna!'],
            [9, $mhs1->id, 5, 'Paling dekat kampus! Jalan kaki 2 menit. AC dan WiFi oke.'],
            [9, $mhs2->id, 4, 'Strategis banget. Fasilitas bagus untuk harga segini.'],
        ];

        foreach ($ulasanData as [$kostIdx, $userId, $rating, $komentar]) {
            if (isset($createdKosts[$kostIdx])) {
                Ulasan::create([
                    'kost_id' => $createdKosts[$kostIdx]->id,
                    'user_id' => $userId,
                    'rating' => $rating,
                    'komentar' => $komentar,
                    'is_approved' => true,
                ]);
            }
        }

        // Update rating rata-rata
        foreach ($createdKosts as $kost) {
            $ulasans = Ulasan::where('kost_id', $kost->id)->where('is_approved', true)->get();
            if ($ulasans->count() > 0) {
                $kost->update([
                    'rating_rata' => round($ulasans->avg('rating'), 2),
                    'jumlah_ulasan' => $ulasans->count(),
                ]);
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('👤 Admin: admin@kostunsr.ac.id / admin123');
        $this->command->info('👤 User: ega@unsur.ac.id / password123');
        $this->command->info('🏠 ' . count($createdKosts) . ' kost berhasil ditambahkan');
    }
}
