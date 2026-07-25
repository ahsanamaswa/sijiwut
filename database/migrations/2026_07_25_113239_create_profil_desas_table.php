<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_create_profil_desas_table.php
    public function up(): void
    {
        Schema::create('profil_desas', function (Blueprint $table) {
            $table->id();
            $table->text('visi')->nullable();
            $table->string('video_profil_url')->nullable();   // <- ganti link video di sini
            $table->string('buku_profil_pdf')->nullable();     // <- ganti PDF di sini
            $table->text('sejarah_intro')->nullable();
            $table->text('sejarah_penutup')->nullable();
            $table->text('sejarah_pemerintahan_intro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_desas');
    }
};
