<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    protected $fillable = ['nama', 'gambar', 'deskripsi', 'urutan'];
    protected static function booted()
    {
        static::addGlobalScope('urutan', fn ($q) => $q->orderBy('urutan'));
    }
}