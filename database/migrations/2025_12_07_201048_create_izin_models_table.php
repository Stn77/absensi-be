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
        Schema::create('izin_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->date('from_date');
            $table->date('until_date');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            $table->enum('jenis', ['datang_terlambat', 'sakit', 'pulang_awal', 'lain_lain'])->default('lain_lain');
            $table->string('keperluan');
            $table->text('catatan');
            $table->string('file_pendukung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_models');
    }
};
