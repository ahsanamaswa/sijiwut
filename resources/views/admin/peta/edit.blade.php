@extends('layouts.app')

@section('title', 'Kelola Informasi Wilayah - Admin')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 bg-forest min-h-screen">
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-cream">Kelola Informasi Wilayah</h1>
                <p class="text-sm text-cream/70">Koordinat, luas, batas wilayah, dan jarak tempuh Desa Jiwut</p>
            </div>
            <a href="{{ route('peta') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-cream/10 text-cream border border-cream/30 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/20 transition">
                <i class="ti ti-external-link"></i> Lihat Halaman Publik
            </a>
        </div>

        <div class="bg-cream/10 text-cream text-sm px-4 py-3 rounded-xl mb-6 border border-cream/20">
            Data di halaman ini sama dengan bagian "Kondisi Geografis" pada halaman
            <a href="{{ route('admin.profil-desa.edit') }}" class="underline font-semibold">Tentang Desa</a>.
            Mengubah data di sini akan otomatis memperbarui informasi di kedua halaman publik.
        </div>

        @if (session('success'))
            <div class="bg-cream/10 text-cream text-sm px-4 py-3 rounded-xl mb-6 border border-cream/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-cream rounded-2xl border border-cream/20 p-6">
            <form action="{{ route('admin.peta.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Letak & Luas --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10">
                    <h2 class="font-heading font-semibold text-forest mb-4">Letak Geografis</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Koordinat</label>
                            <input type="text" name="koordinat" value="{{ old('koordinat', $geo->koordinat) }}"
                                   placeholder="mis. 8.0731° S, 112.2088° E"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('koordinat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Ketinggian</label>
                            <input type="text" name="ketinggian" value="{{ old('ketinggian', $geo->ketinggian) }}"
                                   placeholder="mis. 450 mdpl"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('ketinggian') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Luas Wilayah (Ha)</label>
                            <input type="number" step="0.01" name="luas_total" value="{{ old('luas_total', $geo->luas_total) }}"
                                   placeholder="mis. 320.5"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('luas_total') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Batas Wilayah --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10">
                    <h2 class="font-heading font-semibold text-forest mb-4">Batas Administratif</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Utara</label>
                            <input type="text" name="batas_utara" value="{{ old('batas_utara', $geo->batas_utara) }}"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('batas_utara') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Selatan</label>
                            <input type="text" name="batas_selatan" value="{{ old('batas_selatan', $geo->batas_selatan) }}"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('batas_selatan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Barat</label>
                            <input type="text" name="batas_barat" value="{{ old('batas_barat', $geo->batas_barat) }}"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('batas_barat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Timur</label>
                            <input type="text" name="batas_timur" value="{{ old('batas_timur', $geo->batas_timur) }}"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('batas_timur') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Jarak Tempuh --}}
                <div class="bg-white rounded-2xl p-6 border border-brown/10">
                    <h2 class="font-heading font-semibold text-forest mb-4">Jarak Tempuh</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Ke Kecamatan Nglegok</label>
                            <input type="text" name="jarak_kecamatan" value="{{ old('jarak_kecamatan', $geo->jarak_kecamatan) }}"
                                   placeholder="mis. 3 km"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('jarak_kecamatan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Ke Kabupaten Blitar</label>
                            <input type="text" name="jarak_kabupaten" value="{{ old('jarak_kabupaten', $geo->jarak_kabupaten) }}"
                                   placeholder="mis. 15 km"
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('jarak_kabupaten') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-forest hover:bg-[#2A3A1A] text-cream font-heading font-semibold text-sm px-6 py-3 rounded-xl transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection