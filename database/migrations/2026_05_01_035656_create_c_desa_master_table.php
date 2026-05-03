<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('c_desa_master', function (Blueprint $table) {
        $table->id();
        $table->string('no_c_desa')->unique(); // Contoh: 23
        $table->string('nama_wajib_pajak');    // Contoh: Busero Tawabi
        $table->string('file_scan')->nullable(); // Lokasi penyimpanan file hasil scan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_desa_master');
    }
};
