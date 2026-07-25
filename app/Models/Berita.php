<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'tags',
        'penulis',
        'tanggal',
        'ringkasan',
        'konten',
        'gambar',
        'link_eksternal',
        'views',
        'unggulan',
    ];

    protected $casts = [
        'tags'      => 'array',
        'tanggal'   => 'date',
        'unggulan'  => 'boolean',
    ];

    /**
     * True kalau berita ini sebenarnya artikel dari sumber luar.
     */
    public function getIsExternalAttribute(): bool
    {
        return ! empty($this->link_eksternal);
    }

    /**
     * URL gambar siap-pakai di view.
     * - Kalau 'gambar' sudah berupa URL absolut (http/https) -> dipakai langsung
     *   (biasanya hasil auto-fetch dari artikel sumber luar).
     * - Kalau berupa path relatif -> dianggap file yang diupload ke storage lokal.
     * - Kalau kosong -> fallback ke gambar default.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (empty($this->gambar)) {
            return asset('images/berita/default-thumbnail.jpg');
        }

        if (Str::startsWith($this->gambar, ['http://', 'https://'])) {
            return $this->gambar;
        }

        return asset('storage/'.$this->gambar);
    }

    /**
     * Scope: hanya berita desa (internal).
     */
    public function scopeInternal($query)
    {
        return $query->whereNull('link_eksternal');
    }

    /**
     * Scope: hanya berita dari sumber luar.
     */
    public function scopeExternal($query)
    {
        return $query->whereNotNull('link_eksternal');
    }

    /**
     * Scope: hanya berita yang ditandai admin sebagai unggulan.
     */
    public function scopeUnggulan($query)
    {
        return $query->where('unggulan', true);
    }
}
