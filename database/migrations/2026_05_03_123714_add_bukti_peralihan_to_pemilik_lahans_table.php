<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
            //
            public function up()
{
    Schema::table('pemilik_lahans', function (Blueprint $table) {
        $table->string('bukti_peralihan')->nullable()->after('no_c_desa');
    });
}
      

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilik_lahans', function (Blueprint $table) {
            //
        });
    }
};
