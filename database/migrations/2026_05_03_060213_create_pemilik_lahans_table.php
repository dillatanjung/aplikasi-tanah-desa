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
        Schema::create('pemilik_lahans', function (Blueprint $table) {
            $table->id();
            
            // INI YANG KURANG BOLO! Penghubung ke tabel dhkps
            $table->foreignId('lahan_desa_id')->constrained('dhkps')->onDelete('cascade');
            
            $table->string('nama_pemilik_baru');
            $table->text('alamat_pemilik')->nullable();
            $table->integer('luas_milik');
            $table->string('status'); // SINKRON atau BELUM MUTASI
            $table->string('no_c_desa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilik_lahans');
    }
};