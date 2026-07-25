<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    protected $fillable = [
        'visi',
        'video_profil_url',
        'buku_profil_pdf',
        'sejarah_intro',
        'sejarah_penutup',
        'sejarah_pemerintahan_intro',
    ];

    /**
     * Mengambil satu-satunya data profil desa.
     * Jika belum ada, otomatis membuat record dengan id = 1.
     */
    public static function instance(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            []
        );
    }
}