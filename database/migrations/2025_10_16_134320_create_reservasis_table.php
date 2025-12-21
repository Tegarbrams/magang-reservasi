<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    

    public function up(): void
    {
        // 1. Paket Menu
        Schema::create('paket_menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        // 2. Ruangan
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kapasitas');
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Fasilitas
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 4. Menu Tambahan
        Schema::create('menu_tambahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 5. Reservasi
    Schema::create('reservasis', function (Blueprint $table) {
    $table->id();
    $table->string('nomor_reservasi')->unique(); // Bukan auto increment
    $table->string('nama');
    $table->string('no_hp');
    $table->string('email');
    $table->unsignedBigInteger('paket_menu');
    $table->unsignedBigInteger('ruangan');
    $table->string('jam_check_in');
    $table->decimal('total_harga', 12, 2);
    $table->string('bukti_pembayaran')->nullable();
    $table->text('catatan')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
    $table->timestamps();

    $table->foreign('paket_menu')->references('id')->on('paket_menus')->onDelete('restrict');
    $table->foreign('ruangan')->references('id')->on('ruangans')->onDelete('restrict');
});

        // 6. Pivot Tables
        Schema::create('reservasi_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservasi_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->timestamps();

            $table->foreign('reservasi_id')->references('id')->on('reservasis')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
            $table->unique(['reservasi_id', 'fasilitas_id']);
        });

        Schema::create('reservasi_menu_tambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservasi_id');
            $table->unsignedBigInteger('menu_tambahan_id');
            $table->timestamps();

            $table->foreign('reservasi_id')->references('id')->on('reservasis')->onDelete('cascade');
            $table->foreign('menu_tambahan_id')->references('id')->on('menu_tambahans')->onDelete('cascade');
            $table->unique(['reservasi_id', 'menu_tambahan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_menu_tambahans');
        Schema::dropIfExists('reservasi_fasilitas');
        Schema::dropIfExists('reservasis');
        Schema::dropIfExists('menu_tambahans');
        Schema::dropIfExists('fasilitas');
        Schema::dropIfExists('ruangans');
        Schema::dropIfExists('paket_menus');
    }

    
};