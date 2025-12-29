<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->string('jam_check_in')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->string('jam_check_in')->nullable(false)->change();
        });
    }
};