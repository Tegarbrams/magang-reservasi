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
        // 1. Update tabel reservasis
        Schema::table('reservasis', function (Blueprint $table) {
            $table->string('nomor_reservasi', 20)->change();
            $table->string('nama', 100)->change();
            $table->string('no_hp', 20)->change();
            // email tetap 255 (standar)
            $table->string('jam_check_in', 5)->nullable()->change();
            $table->string('jam', 5)->nullable()->change();
            // bukti_pembayaran tetap 255 (path file)
        });

        // 2. Update tabel blocked_schedules
        Schema::table('blocked_schedules', function (Blueprint $table) {
            $table->string('keterangan', 200)->nullable()->change();
        });

        // 3. Update tabel fasilitas
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('nama', 100)->change();
        });

        // 4. Update tabel menu_tambahans
        Schema::table('menu_tambahans', function (Blueprint $table) {
            $table->string('nama', 100)->change();
        });

        // 5. Update tabel paket_menus
        Schema::table('paket_menus', function (Blueprint $table) {
            $table->string('nama', 100)->change();
            // gambar tetap 255 (path file)
        });

        // 6. Update tabel ruangans
        Schema::table('ruangans', function (Blueprint $table) {
            $table->string('nama', 100)->change();
        });

        // 7. Update tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 100)->change();
            // email tetap 255 (standar)
            $table->string('no_hp', 20)->nullable()->change();
            // password tetap 255 (bcrypt hash)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke semula jika rollback
        
        Schema::table('reservasis', function (Blueprint $table) {
            $table->string('nomor_reservasi', 50)->change();
            $table->string('nama', 255)->change();
            $table->string('no_hp', 255)->change();
            $table->string('jam_check_in', 255)->nullable()->change();
            $table->string('jam', 255)->nullable()->change();
        });

        Schema::table('blocked_schedules', function (Blueprint $table) {
            $table->string('keterangan', 255)->nullable()->change();
        });

        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('nama', 255)->change();
        });

        Schema::table('menu_tambahans', function (Blueprint $table) {
            $table->string('nama', 255)->change();
        });

        Schema::table('paket_menus', function (Blueprint $table) {
            $table->string('nama', 255)->change();
        });

        Schema::table('ruangans', function (Blueprint $table) {
            $table->string('nama', 255)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('no_hp', 255)->nullable()->change();
        });
    }
};