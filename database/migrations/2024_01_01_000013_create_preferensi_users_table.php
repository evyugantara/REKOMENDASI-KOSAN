<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preferensi_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('harga_min')->default(0);
            $table->integer('harga_max')->default(2000000);
            $table->decimal('jarak_max', 5, 2)->default(5.0); // max km dari kampus
            $table->enum('tipe_kost', ['putra', 'putri', 'campur'])->nullable();
            $table->decimal('min_rating', 3, 2)->default(0);
            // Bobot preferensi fasilitas (0-1)
            $table->boolean('butuh_ac')->default(false);
            $table->boolean('butuh_wifi')->default(false);
            $table->boolean('butuh_kamar_mandi_dalam')->default(false);
            $table->boolean('butuh_parkir_motor')->default(false);
            $table->boolean('butuh_parkir_mobil')->default(false);
            $table->boolean('butuh_dapur')->default(false);
            $table->boolean('butuh_laundry')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preferensi_users');
    }
};
