<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest('tanggal')->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        unset($data['gambar']); // ditentukan terpisah lewat resolveGambar()

        $data['slug'] = $this->generateUniqueSlug($data['judul']);
        $data['tags'] = $this->parseTags($request->input('tags'));
        $data['penulis'] = $data['penulis'] ?: (auth()->user()->name ?? 'admin');
        $data['gambar'] = $this->resolveGambar($request, $data);

        Berita::create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('status', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validateData($request, $berita->id);
        unset($data['gambar']); // ditentukan terpisah lewat resolveGambar()

        if ($data['judul'] !== $berita->judul) {
            $data['slug'] = $this->generateUniqueSlug($data['judul'], $berita->id);
        }

        $data['tags'] = $this->parseTags($request->input('tags'));
        $data['penulis'] = $data['penulis'] ?: $berita->penulis;

        // Hanya isi 'gambar' di $data kalau memang ada perubahan gambar.
        // Kalau tidak ada (return null), key 'gambar' TIDAK dimasukkan sama sekali
        // ke $data, supaya update() tidak menimpa gambar lama dengan kosong.
        $newGambar = $this->resolveGambar($request, $data, $berita);
        if ($newGambar !== null) {
            $data['gambar'] = $newGambar;
        }

        $berita->update($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('status', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('status', 'Berita berhasil dihapus.');
    }

    /**
     * Jadikan satu berita sebagai unggulan, otomatis melepas status unggulan
     * dari berita lain (cuma boleh 1 yang unggulan di satu waktu).
     *
     * Kalau berita ini SUDAH unggulan, klik lagi tidak melakukan apa-apa
     * (tidak ada "un-toggle" lewat tombol ini) — untuk ganti berita unggulan,
     * cukup klik bintang di berita lain.
     */
    public function setUnggulan(Berita $berita)
    {
        if ($berita->is_external) {
            return redirect()
                ->route('admin.berita.index')
                ->with('status', 'Berita dari sumber luar tidak bisa dijadikan unggulan.');
        }

        if ($berita->unggulan) {
            return redirect()
                ->route('admin.berita.index')
                ->with('status', 'Berita ini memang sudah jadi unggulan saat ini.');
        }

        Berita::where('unggulan', true)->update(['unggulan' => false]);
        $berita->update(['unggulan' => true]);

        return redirect()
            ->route('admin.berita.index')
            ->with('status', 'Berita ini dijadikan berita unggulan, menggantikan yang sebelumnya.');
    }

    protected function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'judul'          => ['required', 'string', 'max:255'],
            'kategori'       => ['required', 'string', 'max:100'],
            'tags'           => ['nullable', 'string'],
            'penulis'        => ['nullable', 'string', 'max:100'],
            'tanggal'        => ['required', 'date'],
            'ringkasan'      => ['required', 'string', 'max:500'],
            'konten'         => ['required_without:link_eksternal', 'nullable', 'string'],
            'link_eksternal' => ['nullable', 'url', 'max:500'],
            'gambar'         => ['nullable', 'image', 'max:5120'],
        ]);
    }

    protected function parseTags(?string $tags): array
    {
        if (! $tags) {
            return [];
        }

        return collect(explode(',', $tags))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }

    protected function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul);
        $slug = $base;
        $i = 1;

        while (
            Berita::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }

    /**
     * Tentukan nilai 'gambar' yang disimpan:
     * - Kalau admin upload file -> simpan ke storage lokal, pakai path itu.
     * - Kalau tidak upload file TAPI mengisi link_eksternal (baru diisi/diubah)
     *   -> coba ambil otomatis foto pertama dari halaman artikel tersebut.
     * - Kalau tidak ada perubahan apa pun -> return null (artinya: JANGAN ubah
     *   kolom gambar sama sekali, biarkan nilai lama tetap dipakai).
     */
    protected function resolveGambar(Request $request, array $data, ?Berita $existing = null): ?string
    {
        if ($request->hasFile('gambar')) {
            return $request->file('gambar')->store('berita', 'public');
        }

        $isExternal = ! empty($data['link_eksternal']);
        $linkChanged = ! $existing || $existing->link_eksternal !== ($data['link_eksternal'] ?? null);

        if ($isExternal && $linkChanged) {
            $thumb = $this->fetchExternalThumbnail($data['link_eksternal']);
            if ($thumb) {
                return $thumb;
            }
        }

        return null;
    }

    /**
     * Ambil URL foto pertama dari halaman artikel sumber luar.
     * Prioritas: meta og:image -> meta twitter:image -> <img> pertama di halaman.
     * Return null kalau gagal (fallback ke gambar default dihandle di accessor model).
     */
    protected function fetchExternalThumbnail(string $url): ?string
    {
        try {
            $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; DesaJiwutBot/1.0; +https://desajiwut.example)',
                ])
                ->timeout(6)
                ->get($url);

            if (! $response->successful()) {
                return null;
            }

            $html = $response->body();

            if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $m)) {
                return $m[1];
            }

            if (preg_match('/<meta[^>]+name=["\']twitter:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $m)) {
                return $m[1];
            }

            if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
                return $m[1];
            }
    } catch (\Throwable $e) {
                Log::warning('Gagal mengambil thumbnail berita eksternal: '.$e->getMessage());
            }

            return null;
        }
    }