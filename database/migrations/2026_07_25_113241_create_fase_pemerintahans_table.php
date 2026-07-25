<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_create_fase_pemerintahans_table.php
    public function up(): void
    {
        Schema::create('fase_pemerintahans', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->text('deskripsi');
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fase_pemerintahans');
    }
};
