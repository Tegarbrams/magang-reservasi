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
    Schema::table('reservasis', function (Blueprint $table) {
        // Cek apakah kolom masih integer/bigint, ubah ke string
        $table->string('nomor_reservasi', 50)->change();
        
        // Jangan tambah unique lagi karena sudah ada
    });
}

public function down()
{
    Schema::table('reservasis', function (Blueprint $table) {
        $table->unsignedBigInteger('nomor_reservasi')->change();
    });
}
};
