<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('npm')->nullable()->after('name');
            $table->string('phone')->nullable()->after('npm');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('role', ['mahasiswa', 'pemilik', 'admin'])->default('mahasiswa')->after('avatar');
            $table->string('prodi')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['npm', 'phone', 'avatar', 'role', 'prodi']);
        });
    }
};
