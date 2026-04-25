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
    Schema::create('dhkps', function (Blueprint $table) {
        $table->id();
        $table->string('nop')->unique(); // Tambahkan unique di sini sekalian
        $table->string('no_blok')->nullable(); // Tambah ini
        $table->string('no_persil')->nullable(); // Tambah ini
        $table->string('nama_wp');
        $table->text('alamat_wp')->nullable();
        $table->double('luas_bumi')->nullable()->default(0);
        $table->double('luas_bng')->nullable()->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dhkps');
    }
};
