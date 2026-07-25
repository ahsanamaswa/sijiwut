<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Menampilkan halaman Galeri Desa (publik).
     */
    public function index(Request $request)
    {
        $kategoriAktif = $request->query('kategori', 'semua');

        $galeri = Galeri::query()
            ->when(
                $kategoriAktif !== 'semua',
                fn ($query) => $query->where('kategori', $kategoriAktif)
            )
            ->orderByDesc('tanggal')
            ->get();

        $kategoriList = collect(['semua'])->merge(
            Galeri::query()
                ->select('kategori')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori')
        );

        return view('galeri.index', [
            'galeri'        => $galeri,
            'kategoriList'  => $kategoriList,
            'kategoriAktif' => $kategoriAktif,
        ]);
    }
}