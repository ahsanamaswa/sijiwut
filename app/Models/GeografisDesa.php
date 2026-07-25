<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeografisDesa extends Model
{
    protected $table = 'geografis_desas';

    protected $fillable = [
        'luas_total', 'luas_sawah', 'luas_bukan_sawah', 'luas_non_pertanian',
        'koordinat', 'ketinggian', 'topografi', 'curah_hujan',
        'jarak_kecamatan', 'jarak_kabupaten',
        'batas_utara', 'batas_selatan', 'batas_barat', 'batas_timur',
        'catatan_pertanian',
    ];

    /**
     * Mengambil satu-satunya data geografis desa.
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