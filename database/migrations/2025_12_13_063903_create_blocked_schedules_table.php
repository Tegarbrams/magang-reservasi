<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocked_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruangan_id');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('keterangan')->nullable();
            $table->enum('type', ['manual', 'auto'])->default('manual'); // manual = admin block, auto = dari reservasi approved
            $table->unsignedBigInteger('reservasi_id')->nullable(); // jika dari reservasi
            $table->timestamps();

            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('cascade');
            $table->foreign('reservasi_id')->references('id')->on('reservasis')->onDelete('cascade');
            
            // Unique constraint untuk mencegah double booking
            $table->unique(['ruangan_id', 'tanggal', 'jam']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocked_schedules');
    }
};