<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KepalaDesa extends Model
{
    protected $fillable = ['nama', 'masa_jabatan', 'is_aktif', 'urutan'];
    protected static function booted()
    {
        static::addGlobalScope('urutan', fn ($q) => $q->orderBy('urutan'));
    }
}