<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ProfilDesa, Misi, Dusun, FasePemerintahan, KepalaDesa, TokohDesa, GeografisDesa};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilDesaController extends Controller
{
    public function edit()
    {
        return view('admin.profil-desa.edit', [
            'profil' => ProfilDesa::instance(),
            'misi'   => Misi::all(),
            'dusun'  => Dusun::all(),
            'fase'   => FasePemerintahan::all(),
            'kepala' => KepalaDesa::all(),
            'tokoh'  => TokohDesa::all(),
            'geo'    => GeografisDesa::instance(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'visi' => 'nullable|string',
            'video_profil_url' => 'nullable|url',
            'buku_profil_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'sejarah_intro' => 'nullable|string',
            'sejarah_penutup' => 'nullable|string',
            'sejarah_pemerintahan_intro' => 'nullable|string',

            'misi' => 'nullable|array',
            'misi.*' => 'nullable|string',

            'dusun' => 'nullable|array',
            'dusun.*.nama' => 'required_with:dusun|string',
            'dusun.*.deskripsi' => 'required_with:dusun|string',
            'dusun.*.gambar' => 'nullable|file|image|max:4096',
            'dusun.*.id' => 'nullable|integer',

            'fase' => 'nullable|array',
            'fase.*.periode' => 'required_with:fase|string',
            'fase.*.deskripsi' => 'required_with:fase|string',

            'kepala' => 'nullable|array',
            'kepala.*.nama' => 'required_with:kepala|string',
            'kepala.*.masa_jabatan' => 'required_with:kepala|string',

            'tokoh' => 'nullable|array',
            'tokoh.*.nama' => 'required_with:tokoh|string',

            'geo.luas_total' => 'nullable|numeric',
            'geo.luas_sawah' => 'nullable|numeric',
            'geo.luas_bukan_sawah' => 'nullable|numeric',
            'geo.luas_non_pertanian' => 'nullable|numeric',
            'geo.koordinat' => 'nullable|string',
            'geo.ketinggian' => 'nullable|string',
            'geo.topografi' => 'nullable|string',
            'geo.curah_hujan' => 'nullable|string',
            'geo.jarak_kecamatan' => 'nullable|string',
            'geo.jarak_kabupaten' => 'nullable|string',
            'geo.batas_utara' => 'nullable|string',
            'geo.batas_selatan' => 'nullable|string',
            'geo.batas_barat' => 'nullable|string',
            'geo.batas_timur' => 'nullable|string',
            'geo.catatan_pertanian' => 'nullable|string',
        ]);

        // Profil singleton (termasuk video & PDF)
        $profil = ProfilDesa::instance();
        $profil->visi = $data['visi'] ?? null;
        $profil->video_profil_url = $data['video_profil_url'] ?? null;
        $profil->sejarah_intro = $data['sejarah_intro'] ?? null;
        $profil->sejarah_penutup = $data['sejarah_penutup'] ?? null;
        $profil->sejarah_pemerintahan_intro = $data['sejarah_pemerintahan_intro'] ?? null;

        if ($request->hasFile('buku_profil_pdf')) {
            if ($profil->buku_profil_pdf) {
                Storage::disk('public')->delete($profil->buku_profil_pdf);
            }
            $profil->buku_profil_pdf = $request->file('buku_profil_pdf')->store('files', 'public');
        }
        $profil->save();

        // Misi
        Misi::query()->delete();
        foreach (array_values($request->input('misi', [])) as $i => $isi) {
            if (trim((string) $isi) === '') continue;
            Misi::create(['isi' => $isi, 'urutan' => $i]);
        }

        // Dusun (jaga file gambar lama kalau tidak diganti)
        $keepDusunIds = [];
        foreach ($request->input('dusun', []) as $i => $row) {
            $dusun = isset($row['id']) ? Dusun::find($row['id']) : null;
            $dusun ??= new Dusun();
            $dusun->nama = $row['nama'];
            $dusun->deskripsi = $row['deskripsi'];
            $dusun->urutan = $i;

            if ($request->hasFile("dusun.$i.gambar")) {
                if ($dusun->gambar) Storage::disk('public')->delete($dusun->gambar);
                $dusun->gambar = $request->file("dusun.$i.gambar")->store('dusun', 'public');
            }
            $dusun->save();
            $keepDusunIds[] = $dusun->id;
        }
        Dusun::whereNotIn('id', $keepDusunIds)->get()->each(function ($d) {
            if ($d->gambar) Storage::disk('public')->delete($d->gambar);
            $d->delete();
        });

        // Fase pemerintahan
        FasePemerintahan::query()->delete();
        foreach ($request->input('fase', []) as $i => $row) {
            if (empty($row['periode'])) continue;
            FasePemerintahan::create(['periode' => $row['periode'], 'deskripsi' => $row['deskripsi'], 'urutan' => $i]);
        }

        // Kepala desa
        KepalaDesa::query()->delete();
        foreach ($request->input('kepala', []) as $i => $row) {
            if (empty($row['nama'])) continue;
            KepalaDesa::create([
                'nama' => $row['nama'],
                'masa_jabatan' => $row['masa_jabatan'],
                'is_aktif' => isset($row['is_aktif']),
                'urutan' => $i,
            ]);
        }

        // Tokoh
        TokohDesa::query()->delete();
        foreach ($request->input('tokoh', []) as $i => $row) {
            if (empty($row['nama'])) continue;
            TokohDesa::create([
                'nama' => $row['nama'],
                'alamat' => $row['alamat'] ?? null,
                'tahun' => $row['tahun'] ?? null,
                'unsur' => $row['unsur'] ?? null,
                'urutan' => $i,
            ]);
        }


    GeografisDesa::instance()->update($data['geo'] ?? []);

        return back()->with('success', 'Perubahan berhasil disimpan.');
    }
}
