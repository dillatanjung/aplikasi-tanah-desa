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
        Schema::create('lahan_desa', function (Blueprint $table) {
            $table->id('id_lahan');
            
            // Nama kolom dan panjang karakter (string) disamakan dengan tabel dhkps
            $table->string('nop_dhkp', 255); 
            
            $table->string('no_c_desa', 20)->nullable();
            $table->string('no_persil', 20)->nullable(); // Di dhkps sudah ada, tapi di sini untuk record desa
            $table->string('no_blok', 10)->nullable();
            $table->string('kelas_desa', 10)->nullable();
            $table->integer('id_geometry')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->timestamps();

            // SINKRONISASI: Referensi ke tabel 'dhkps' (pakai 's') dan kolom 'nop'
            $table->foreign('nop_dhkp')
                  ->references('nop')
                  ->on('dhkps') 
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahan_desa');
    }
};