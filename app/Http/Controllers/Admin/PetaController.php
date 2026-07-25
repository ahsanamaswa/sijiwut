<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeografisDesa;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    /**
     * Halaman admin untuk kelola informasi wilayah di halaman Peta.
     * Sumber data sama persis dengan yang dipakai di Tentang Desa (tabel geografis_desas),
     * supaya data selalu sinkron di kedua halaman publik.
     */
    public function edit()
    {
        return view('admin.peta.edit', [
            'geo' => GeografisDesa::instance(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'koordinat'         => 'nullable|string|max:255',
            'ketinggian'        => 'nullable|string|max:255',
            'luas_total'        => 'nullable|numeric',
            'batas_utara'       => 'nullable|string|max:255',
            'batas_selatan'     => 'nullable|string|max:255',
            'batas_barat'       => 'nullable|string|max:255',
            'batas_timur'       => 'nullable|string|max:255',
            'jarak_kecamatan'   => 'nullable|string|max:255',
            'jarak_kabupaten'   => 'nullable|string|max:255',
        ]);

        GeografisDesa::instance()->update($data);

        return back()->with('success', 'Informasi wilayah berhasil diperbarui.');
    }
}