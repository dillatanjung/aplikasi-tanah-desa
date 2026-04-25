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
    Schema::create('penduduks', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 16)->unique(); 
        $table->string('nama');
        $table->text('alamat')->nullable();
        $table->string('pekerjaan')->nullable();
        $table->timestamps();
    });
}
};
