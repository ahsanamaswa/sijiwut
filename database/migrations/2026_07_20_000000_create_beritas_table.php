<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori');
            $table->json('tags')->nullable();
            $table->string('penulis')->nullable();
            $table->date('tanggal');
            $table->text('ringkasan');
            $table->longText('konten')->nullable(); // null kalau berita bersumber luar
            $table->string('gambar')->nullable();   // path lokal (storage) ATAU url gambar remote
            $table->string('link_eksternal')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
