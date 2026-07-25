<?php

namespace App\Http\Controllers;

use App\Models\ProfilDesa;
use App\Models\Misi;
use App\Models\Dusun;
use App\Models\FasePemerintahan;
use App\Models\KepalaDesa;
use App\Models\TokohDesa;
use App\Models\GeografisDesa;

class TentangDesaController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::instance();
        $geo    = GeografisDesa::instance();

        $misi       = Misi::all();
        $dusunList  = Dusun::all();
        $fase       = FasePemerintahan::all();
        $kepalaList = KepalaDesa::all();
        $tokohList  = TokohDesa::all();

        return view('tentang-desa', compact(
            'profil', 'misi', 'dusunList', 'fase', 'kepalaList', 'tokohList', 'geo'
        ));
    }
}