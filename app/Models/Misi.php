<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    protected $fillable = [
        'isi',
        'urutan',
    ];

    /**
     * Global scope untuk mengurutkan data berdasarkan kolom urutan.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('urutan', function (Builder $query) {
            $query->orderBy('urutan');
        });
    }
}