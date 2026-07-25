@extends('layouts.app')

@section('title', 'Kelola Tentang Desa - Admin')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 bg-forest min-h-screen">
    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-cream">Kelola Halaman Tentang Desa</h1>
                <p class="text-sm text-cream/70">Visi misi, sejarah, geografis, hingga video &amp; buku profil desa</p>
            </div>
            <a href="{{ route('tentang-desa') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-cream/10 text-cream border border-cream/30 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/20 transition">
                <i class="ti ti-external-link"></i> Lihat Halaman Publik
            </a>
        </div>

        @if (session('success'))
            <div class="bg-cream/10 text-cream text-sm px-4 py-3 rounded-xl mb-6 border border-cream/20">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500/10 text-red-100 text-sm rounded-xl p-4 mb-6 border border-red-400/30">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-cream rounded-2xl border border-cream/20 p-6">
            <form action="{{ route('admin.profil-desa.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf @method('PUT')

                {{-- VISI --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10">
                    <h2 class="font-heading font-semibold text-forest text-lg mb-3">Visi</h2>
                    <textarea name="visi" rows="3" class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">{{ old('visi', $profil->visi) }}</textarea>
                </div>

                {{-- MISI (repeater) --}}
                <div x-data="{ items: {{ Js::from($misi->pluck('isi')->values()) }} }" class="bg-white rounded-2xl p-6 border border-brown/10">
                    <h2 class="font-heading font-semibold text-forest text-lg mb-3">Misi</h2>
                    <template x-for="(item, i) in items" :key="i">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="`misi[${i}]`" x-model="items[i]"
                                   class="flex-1 border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            <button type="button" @click="items.splice(i, 1)"
                                    class="w-9 h-9 rounded-lg bg-red-50 text-red-600">✕</button>
                        </div>
                    </template>
                    <button type="button" @click="items.push('')"
                            class="text-sm text-forest font-semibold mt-2">+ Tambah poin misi</button>
                </div>

                {{-- SEJARAH --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10 space-y-4">
                    <h2 class="font-heading font-semibold text-forest text-lg">Sejarah Desa</h2>
                    <div>
                        <label class="text-sm text-brown/70">Paragraf pembuka</label>
                        <textarea name="sejarah_intro" rows="4" class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">{{ old('sejarah_intro', $profil->sejarah_intro) }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm text-brown/70">Paragraf penutup (berdirinya desa)</label>
                        <textarea name="sejarah_penutup" rows="4" class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">{{ old('sejarah_penutup', $profil->sejarah_penutup) }}</textarea>
                    </div>
                </div>

                {{-- ASAL USUL DUSUN (repeater dengan gambar) --}}
                <div x-data="{
                        items: {{ Js::from($dusun->map(fn($d) => ['id'=>$d->id,'nama'=>$d->nama,'deskripsi'=>$d->deskripsi,'gambar_url'=>$d->gambar?asset('storage/'.$d->gambar):null])) }}
                     }" class="bg-white rounded-2xl p-6 border border-brown/10">
                    <h2 class="font-heading font-semibold text-forest text-lg mb-3">Asal Usul Dusun</h2>
                    <template x-for="(item, i) in items" :key="i">
                        <div class="border border-brown/10 rounded-xl p-4 mb-3 space-y-2">
                            <input type="hidden" :name="`dusun[${i}][id]`" :value="item.id">
                            <input type="text" :name="`dusun[${i}][nama]`" x-model="item.nama" placeholder="Nama dusun"
                                   class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-forest/30">
                            <textarea :name="`dusun[${i}][deskripsi]`" x-model="item.deskripsi" rows="4" placeholder="Deskripsi asal-usul"
                                      class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30"></textarea>
                            <div class="flex items-center gap-3">
                                <img :src="item.gambar_url" x-show="item.gambar_url" class="w-20 h-14 object-cover rounded">
                                <input type="file" :name="`dusun[${i}][gambar]`" accept="image/*" class="text-sm">
                            </div>
                            <button type="button" @click="items.splice(i, 1)" class="text-xs text-red-600">Hapus dusun ini</button>
                        </div>
                    </template>
                    <button type="button" @click="items.push({id:null, nama:'', deskripsi:'', gambar_url:null})"
                            class="text-sm text-forest font-semibold">+ Tambah dusun</button>
                </div>

                {{-- SEJARAH PEMERINTAHAN --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10 space-y-4">
                    <h2 class="font-heading font-semibold text-forest text-lg">Sejarah Pemerintahan</h2>
                    <textarea name="sejarah_pemerintahan_intro" rows="3"
                              class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">{{ old('sejarah_pemerintahan_intro', $profil->sejarah_pemerintahan_intro) }}</textarea>

                    {{-- Timeline fase --}}
                    <div x-data="{ items: {{ Js::from($fase->map(fn($f)=>['periode'=>$f->periode,'deskripsi'=>$f->deskripsi])) }} }">
                        <h3 class="text-sm font-semibold text-brown/70 mt-4 mb-2">Timeline Regulasi</h3>
                        <template x-for="(item, i) in items" :key="i">
                            <div class="border border-brown/10 rounded-xl p-3 mb-2 space-y-2">
                                <input type="text" :name="`fase[${i}][periode]`" x-model="item.periode" placeholder="Contoh: UU No. 5 Tahun 1979"
                                       class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-forest/30">
                                <textarea :name="`fase[${i}][deskripsi]`" x-model="item.deskripsi" rows="2"
                                          class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30"></textarea>
                                <button type="button" @click="items.splice(i,1)" class="text-xs text-red-600">Hapus</button>
                            </div>
                        </template>
                        <button type="button" @click="items.push({periode:'', deskripsi:''})"
                                class="text-sm text-forest font-semibold">+ Tambah fase</button>
                    </div>

                    {{-- Tabel kepala desa --}}
                    <div x-data="{ items: {{ Js::from($kepala->map(fn($k)=>['nama'=>$k->nama,'masa_jabatan'=>$k->masa_jabatan,'is_aktif'=>$k->is_aktif])) }} }">
                        <h3 class="text-sm font-semibold text-brown/70 mt-6 mb-2">Daftar Kepala Desa</h3>
                        <template x-for="(item, i) in items" :key="i">
                            <div class="flex gap-2 mb-2 items-center">
                                <input type="text" :name="`kepala[${i}][nama]`" x-model="item.nama" placeholder="Nama"
                                       class="flex-1 border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                                <input type="text" :name="`kepala[${i}][masa_jabatan]`" x-model="item.masa_jabatan" placeholder="1895 - 1905"
                                       class="w-40 border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                                <label class="text-xs flex items-center gap-1">
                                    <input type="checkbox" :name="`kepala[${i}][is_aktif]`" x-model="item.is_aktif"> Aktif
                                </label>
                                <button type="button" @click="items.splice(i,1)" class="text-red-600 text-xs">✕</button>
                            </div>
                        </template>
                        <button type="button" @click="items.push({nama:'', masa_jabatan:'', is_aktif:false})"
                                class="text-sm text-forest font-semibold">+ Tambah kepala desa</button>
                    </div>

                    {{-- Tabel tokoh --}}
                    <div x-data="{ items: {{ Js::from($tokoh->map(fn($t)=>['nama'=>$t->nama,'alamat'=>$t->alamat,'tahun'=>$t->tahun,'unsur'=>$t->unsur])) }} }">
                        <h3 class="text-sm font-semibold text-brown/70 mt-6 mb-2">Tokoh Berpengaruh</h3>
                        <template x-for="(item, i) in items" :key="i">
                            <div class="grid grid-cols-4 gap-2 mb-2">
                                <input type="text" :name="`tokoh[${i}][nama]`" x-model="item.nama" placeholder="Nama" class="border border-brown/20 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                                <input type="text" :name="`tokoh[${i}][alamat]`" x-model="item.alamat" placeholder="Alamat" class="border border-brown/20 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                                <input type="text" :name="`tokoh[${i}][tahun]`" x-model="item.tahun" placeholder="1930-2005" class="border border-brown/20 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                                <div class="flex gap-1">
                                    <input type="text" :name="`tokoh[${i}][unsur]`" x-model="item.unsur" placeholder="Unsur" class="flex-1 border border-brown/20 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                                    <button type="button" @click="items.splice(i,1)" class="text-red-600 text-xs">✕</button>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="items.push({nama:'',alamat:'',tahun:'',unsur:''})"
                                class="text-sm text-forest font-semibold">+ Tambah tokoh</button>
                    </div>
                </div>

                {{-- GEOGRAFIS (dipakai juga di halaman Peta) --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10 space-y-4">
                    <h2 class="font-heading font-semibold text-forest text-lg">Kondisi Geografis <span class="text-xs text-brown/50 font-normal">(tampil di Tentang Desa &amp; Peta Desa)</span></h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <input type="number" step="0.1" name="geo[luas_total]" value="{{ old('geo.luas_total',$geo->luas_total) }}" placeholder="Luas total (Ha)" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="number" step="0.1" name="geo[luas_sawah]" value="{{ old('geo.luas_sawah',$geo->luas_sawah) }}" placeholder="Luas sawah (Ha)" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="number" step="0.1" name="geo[luas_bukan_sawah]" value="{{ old('geo.luas_bukan_sawah',$geo->luas_bukan_sawah) }}" placeholder="Luas bukan sawah (Ha)" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="number" step="0.1" name="geo[luas_non_pertanian]" value="{{ old('geo.luas_non_pertanian',$geo->luas_non_pertanian) }}" placeholder="Luas non pertanian (Ha)" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <input type="text" name="geo[koordinat]" value="{{ old('geo.koordinat',$geo->koordinat) }}" placeholder="Koordinat" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[ketinggian]" value="{{ old('geo.ketinggian',$geo->ketinggian) }}" placeholder="Ketinggian" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[topografi]" value="{{ old('geo.topografi',$geo->topografi) }}" placeholder="Topografi" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[curah_hujan]" value="{{ old('geo.curah_hujan',$geo->curah_hujan) }}" placeholder="Curah hujan" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[jarak_kecamatan]" value="{{ old('geo.jarak_kecamatan',$geo->jarak_kecamatan) }}" placeholder="Jarak ke kecamatan" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[jarak_kabupaten]" value="{{ old('geo.jarak_kabupaten',$geo->jarak_kabupaten) }}" placeholder="Jarak ke kabupaten" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <input type="text" name="geo[batas_utara]" value="{{ old('geo.batas_utara',$geo->batas_utara) }}" placeholder="Batas utara" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[batas_selatan]" value="{{ old('geo.batas_selatan',$geo->batas_selatan) }}" placeholder="Batas selatan" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[batas_barat]" value="{{ old('geo.batas_barat',$geo->batas_barat) }}" placeholder="Batas barat" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <input type="text" name="geo[batas_timur]" value="{{ old('geo.batas_timur',$geo->batas_timur) }}" placeholder="Batas timur" class="border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                    </div>
                    <textarea name="geo[catatan_pertanian]" rows="3" placeholder="Catatan pertanian & pengairan"
                              class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">{{ old('geo.catatan_pertanian',$geo->catatan_pertanian) }}</textarea>
                </div>

                {{-- VIDEO & BUKU PROFIL --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10 space-y-4">
                    <h2 class="font-heading font-semibold text-forest text-lg">Video &amp; Buku Profil Desa</h2>
                    <div>
                        <label class="text-sm text-brown/70">Link video YouTube</label>
                        <input type="url" name="video_profil_url" value="{{ old('video_profil_url',$profil->video_profil_url) }}"
                               class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30" placeholder="https://youtu.be/xxxxxxxxxxx">
                    </div>
                    <div>
                        <label class="text-sm text-brown/70">Buku profil (PDF)</label>
                        @if ($profil->buku_profil_pdf)
                            <p class="text-xs text-brown/60 mb-1">
                                File saat ini: <a href="{{ Storage::url($profil->buku_profil_pdf) }}" target="_blank" class="underline">lihat PDF</a>
                            </p>
                        @endif
                        <input type="file" name="buku_profil_pdf" accept="application/pdf" class="w-full border border-brown/20 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-forest hover:bg-[#2A3A1A] text-cream font-heading font-semibold text-sm px-6 py-3 rounded-xl transition">
                        Simpan Semua Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection