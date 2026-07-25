<?php

namespace App\Http\Controllers;

use App\Models\GeografisDesa;

class PetaController extends Controller
{
    public function index()
    {
        $geo = GeografisDesa::instance();

        return view('peta', compact('geo'));
    }
}