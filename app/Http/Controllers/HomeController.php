<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data sementara hardcode sesuai papan struktur organisasi.
        // Nanti pindahkan ke tabel `perangkat_desa` supaya bisa diedit
        // dari dashboard admin tanpa perlu ubah kode.
        $struktur = [
            'kepala_desa' => ['jabatan' => 'Kepala Desa Jiwut', 'nama' => 'Yanwar'],

            'sekretaris' => ['jabatan' => 'Sekretaris Desa Jiwut', 'nama' => 'Miftachul Munir'],

            'kasi' => [
                ['jabatan' => 'Kepala Seksi Pemerintahan', 'nama' => 'Suharto'],
                ['jabatan' => 'Kepala Seksi Kesejahteraan', 'nama' => 'Ali Riduwan'],
                ['jabatan' => 'Kepala Seksi Pelayanan', 'nama' => 'Chabib Isngadi'],
            ],

            'kaur' => [
                ['jabatan' => 'Kaur Tata Usaha & Umum', 'nama' => 'Badrun Munir'],
                ['jabatan' => 'Kaur Keuangan', 'nama' => 'M. Awi'],
                ['jabatan' => 'Kaur Perencanaan', 'nama' => 'Eva Septi Puspita'],
            ],

            'kamituwo' => [
                ['jabatan' => 'Kamituwo Ngrobyong', 'nama' => 'Catur Karya K.A.'],
                ['jabatan' => 'Kamituwo Darungan', 'nama' => 'Tukiyat'],
                ['jabatan' => 'Kamituwo Klampok', 'nama' => 'Eko Purwiyanto'],
                ['jabatan' => 'Kamituwo Jiwut', 'nama' => 'Azwar Anas'],
                ['jabatan' => 'Kamituwo Semol', 'nama' => 'Badrun Munir'],
            ],
        ];

        // Berita unggulan: diambil dari berita yang ditandai admin sebagai
        // unggulan (kolom `unggulan` = true). Kalau belum ada admin yang
        // menandai satupun, fallback ke berita internal terbaru supaya
        // section ini tidak kosong.
        $beritaUnggulan = Berita::internal()->unggulan()->latest('tanggal')->first()
            ?? Berita::internal()->latest('tanggal')->first();

        // Berita terkini: berita internal terbaru, tidak termasuk yang
        // sedang dipakai sebagai berita unggulan supaya tidak dobel tampil.
        $beritaTerkini = Berita::internal()
            ->when($beritaUnggulan, fn ($q) => $q->where('id', '!=', $beritaUnggulan->id))
            ->latest('tanggal')
            ->take(3)
            ->get();

        $kategoriBerita = ['Tentang Desa', 'Peta', 'Galeri Desa', 'Berita'];

        return view('home', compact('struktur', 'beritaUnggulan', 'beritaTerkini', 'kategoriBerita'));
    }
}
