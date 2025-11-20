<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_absens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->date('tanggal');
            $table->string('hari');
            $table->time('waktu_absen');
            $table->enum('jenis', ['datang', 'pulang']);
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('is_late', ['Terlambat', 'Tepat Waktu'])->default('Tepat Waktu');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_absens');
    }
};
