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
        Schema::create('marka_jalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->nullable();
            $table->string('nama_marka')->nullable();
            $table->string('jenis_marka')->nullable();
            $table->string('jalur')->nullable();
            $table->string('panjang_jalan')->nullable();
            $table->string('luas')->nullable();
            $table->string('tahun_pembuatan')->nullable();
            $table->string('panjang_marka')->nullable();
            $table->string('lebar_marka')->nullable();
            $table->string('jumlah_garis')->nullable();
            $table->string('jumlah_marka')->nullable();
            $table->string('ketebalan')->nullable();
            $table->string('deskripsi')->nullable();
            $table->json('geojson');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marka_jalans');
    }
};
