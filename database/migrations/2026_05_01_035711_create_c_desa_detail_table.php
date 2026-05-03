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
    Schema::create('c_desa_detail', function (Blueprint $table) {
        $table->id();
        $table->foreignId('c_desa_master_id')->constrained('c_desa_master')->onDelete('cascade');
        $table->enum('klasifikasi', ['sawah', 'kering']); 
        $table->string('no_persil');
        $table->string('kelas_desa'); 
        $table->decimal('luas_ha', 12, 4)->default(0); // Menggunakan decimal agar bisa input 0.1234 ha
        $table->text('sebab_perubahan')->nullable(); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_desa_detail');
    }
};
