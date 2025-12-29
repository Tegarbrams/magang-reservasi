<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->enum('tipe_pembayaran', ['dp_20', 'dp_50', 'full'])->default('full')->after('total_harga');
            $table->decimal('jumlah_dibayar', 12, 2)->after('tipe_pembayaran');
            $table->decimal('sisa_pembayaran', 12, 2)->default(0)->after('jumlah_dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['tipe_pembayaran', 'jumlah_dibayar', 'sisa_pembayaran']);
        });
    }
};