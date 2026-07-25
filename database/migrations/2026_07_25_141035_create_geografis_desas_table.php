<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_create_geografis_desas_table.php
    public function up(): void
    {
        Schema::create('geografis_desas', function (Blueprint $table) {
            $table->id();
            $table->string('luas_total')->nullable();
            $table->string('luas_sawah')->nullable();
            $table->string('luas_bukan_sawah')->nullable();
            $table->string('luas_non_pertanian')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('ketinggian')->nullable();
            $table->string('topografi')->nullable();
            $table->string('curah_hujan')->nullable();
            $table->string('jarak_kecamatan')->nullable();
            $table->string('jarak_kabupaten')->nullable();
            $table->string('batas_utara')->nullable();
            $table->string('batas_selatan')->nullable();
            $table->string('batas_barat')->nullable();
            $table->string('batas_timur')->nullable();
            $table->text('catatan_pertanian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geografis_desas');
    }
};
