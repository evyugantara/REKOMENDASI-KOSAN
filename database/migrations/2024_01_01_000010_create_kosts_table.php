<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('alamat');
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->integer('harga_per_bulan');
            $table->enum('tipe', ['putra', 'putri', 'campur']);
            $table->integer('jumlah_kamar');
            $table->integer('kamar_tersedia');
            $table->string('no_whatsapp');
            $table->string('pemilik');
            $table->string('foto_utama')->nullable();
            // Fasilitas kamar
            $table->boolean('fasilitas_ac')->default(false);
            $table->boolean('fasilitas_wifi')->default(false);
            $table->boolean('fasilitas_kamar_mandi_dalam')->default(false);
            $table->boolean('fasilitas_lemari')->default(false);
            $table->boolean('fasilitas_kasur')->default(false);
            $table->boolean('fasilitas_meja_kursi')->default(false);
            // Fasilitas umum
            $table->boolean('fasilitas_parkir_motor')->default(false);
            $table->boolean('fasilitas_parkir_mobil')->default(false);
            $table->boolean('fasilitas_dapur')->default(false);
            $table->boolean('fasilitas_laundry')->default(false);
            $table->boolean('fasilitas_cctv')->default(false);
            $table->boolean('fasilitas_mushola')->default(false);
            // Computed / aggregated
            $table->decimal('rating_rata', 3, 2)->default(0);
            $table->integer('jumlah_ulasan')->default(0);
            $table->decimal('jarak_kampus', 8, 3)->nullable(); // dalam km
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
