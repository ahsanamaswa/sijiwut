<?php

use Illuminate\Support\Facades\Route;

use App\Models\Berita;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TentangDesaController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BeritaController;

use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\ProfilDesaController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\PetaController as AdminPetaController;

// ================= Publik (tanpa login) =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-desa', [TentangDesaController::class, 'index'])->name('tentang-desa');
Route::get('/peta', [PetaController::class, 'index'])->name('peta');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Sitemap untuk SEO
Route::get('/sitemap.xml', function () {
    $urls = collect([
        ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
        ['loc' => route('tentang-desa'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => route('peta'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['loc' => route('galeri.index'), 'priority' => '0.7', 'changefreq' => 'weekly'],
        ['loc' => route('berita.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
    ]);

    Berita::all()->each(function ($berita) use ($urls) {
        $urls->push([
            'loc' => route('berita.show', $berita->slug),
            'priority' => '0.6',
            'changefreq' => 'monthly',
            'lastmod' => $berita->updated_at->toAtomString(),
        ]);
    });

    return response()
        ->view('sitemap', compact('urls'))
        ->header('Content-Type', 'text/xml');
})->name('sitemap');

// Redirect bawaan Breeze setelah login berhasil
Route::get('/dashboard', function () {
    return redirect()->route('admin.berita.index');
})->middleware('auth')->name('dashboard');

// ================= Admin (wajib login + role admin) =================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Kelola Berita
    Route::resource('berita', AdminBeritaController::class)
        ->except('show')
        ->parameters(['berita' => 'berita']);

    Route::patch('berita/{berita}/unggulan', [AdminBeritaController::class, 'setUnggulan'])
        ->name('berita.set-unggulan');

    // Kelola Profil Desa
    Route::get('profil-desa', [ProfilDesaController::class, 'edit'])->name('profil-desa.edit');
    Route::put('profil-desa', [ProfilDesaController::class, 'update'])->name('profil-desa.update');

    // Kelola Peta (pakai data GeografisDesa yang sama dengan Tentang Desa)
    Route::get('peta', [AdminPetaController::class, 'edit'])->name('peta.edit');
    Route::put('peta', [AdminPetaController::class, 'update'])->name('peta.update');

    // Kelola Galeri
    Route::resource('galeri', AdminGaleriController::class)->except('show');
});

require __DIR__.'/auth.php';