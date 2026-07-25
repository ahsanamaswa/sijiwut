<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TokohDesa extends Model
{
    protected $fillable = ['nama', 'alamat', 'tahun', 'unsur', 'urutan'];
    protected static function booted()
    {
        static::addGlobalScope('urutan', fn ($q) => $q->orderBy('urutan'));
    }
}