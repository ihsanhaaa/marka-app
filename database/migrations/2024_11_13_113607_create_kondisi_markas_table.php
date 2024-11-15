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
        Schema::create('kondisi_markas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marka_jalan_id')->constrained()->onDelete('cascade');
            $table->date('tgl_temuan')->nullable();
            $table->string('status_marka')->nullable();
            $table->string('kondisi_marka')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_markas');
    }
};
