<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $beritaInternal = Berita::internal()->latest('tanggal')->take(9)->get();
        $beritaEksternal = Berita::external()->latest('tanggal')->take(9)->get();

        return view('berita.index', compact('beritaInternal', 'beritaEksternal'));
    }

    public function show(string $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Kalau ternyata ini artikel sumber luar, jangan tampilkan halaman detail
        // internal — arahkan langsung ke sumber aslinya.
        if ($berita->is_external) {
            return redirect()->away($berita->link_eksternal);
        }

        $berita->increment('views');

        $lainnya = Berita::where('id', '!=', $berita->id)
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('berita.show', compact('berita', 'lainnya'));
    }

    /**
     * Dipakai section Berita di halaman Home (berita terbaru gabungan internal+eksternal).
     */
    public function latest(int $limit = 3)
    {
        return Berita::latest('tanggal')->take($limit)->get();
    }
}
