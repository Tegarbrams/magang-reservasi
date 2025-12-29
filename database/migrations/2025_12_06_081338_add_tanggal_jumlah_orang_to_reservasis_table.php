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
        Schema::table('reservasis', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('reservasis', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('jam_check_in');
            }
            
            if (!Schema::hasColumn('reservasis', 'jumlah_orang')) {
                $table->integer('jumlah_orang')->default(1)->after('tanggal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['tanggal', 'jumlah_orang']);
        });
    }
};