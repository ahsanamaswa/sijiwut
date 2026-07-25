<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FasePemerintahan extends Model
{
    protected $fillable = ['periode', 'deskripsi', 'urutan'];
    protected static function booted()
    {
        static::addGlobalScope('urutan', fn ($q) => $q->orderBy('urutan'));
    }
}