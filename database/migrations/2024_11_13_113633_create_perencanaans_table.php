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
        Schema::create('perencanaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marka_jalan_id')->constrained()->onDelete('cascade');
            $table->date('tgl_usulan')->nullable();
            $table->date('tgl_disetujui')->nullable();
            $table->string('status_perencanaan')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaans');
    }
};
