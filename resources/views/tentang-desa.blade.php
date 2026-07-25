@extends('layouts.app')

@section('title', 'Tentang Desa - Sistem Informasi Desa Jiwut')

@section('content')

{{-- ================= FOTO KANTOR DESA ================= --}}
<section class="relative w-full h-[300px] md:h-[380px] overflow-hidden">
    <img src="{{ asset('images/kantor.png') }}" alt="Kantor Desa Jiwut"
         class="absolute inset-0 w-full h-full object-cover">

    {{-- Overlay gradient animasi --}}
    <div class="absolute inset-0 gradient-animated"></div>

    <div class="relative z-10 h-full flex items-center justify-between px-6 md:px-20">
        <h1 class="font-heading font-extrabold text-4xl md:text-5xl text-cream">Tentang Desa</h1>

        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.profil-desa.edit') }}"
               class="inline-flex items-center gap-2 bg-cream text-forest px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/90 transition flex-shrink-0">
                <i class="ti ti-pencil"></i> Kelola Halaman Ini
            </a>
        @endif
    </div>
</section>

{{-- ================= VISI & MISI (cream) ================= --}}
<section id="visi-misi" class="relative py-20 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-cream">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-brown mb-2">Visi &amp; Misi</h2>
            <div class="w-16 h-1 bg-gold rounded-full mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Visi --}}
            <div class="bg-gradient-to-br from-[#354623] to-[#82AC56] text-cream rounded-2xl p-8 border-2 border-[#2A1F12]">
                <p class="font-heading font-bold text-lg mb-4 flex items-center gap-2">
                    Visi
                </p>
                @if ($profil->visi)
                    <p class="leading-relaxed italic">
                        "{{ $profil->visi }}"
                    </p>
                @else
                    <p class="leading-relaxed italic text-cream/60">Visi desa belum ditambahkan.</p>
                @endif
            </div>

            {{-- Misi --}}
            <div class="bg-white text-brown rounded-2xl p-8 border border-brown/10">
                <p class="font-heading font-bold text-lg mb-4 flex items-center gap-2 text-forest">
                    Misi
                </p>
                @if ($misi->isEmpty())
                    <p class="text-sm text-brown/60">Misi desa belum ditambahkan.</p>
                @else
                    <ol class="space-y-3 text-sm leading-relaxed list-decimal list-inside">
                        @foreach ($misi as $m)
                            <li>{{ $m->isi }}</li>
                        @endforeach
                    </ol>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- ================= VIDEO PROFIL DESA (hijau) ================= --}}
@php
    $videoProfilUrl = $profil->video_profil_url;
    $videoId = null;

    if ($videoProfilUrl) {
        preg_match(
            '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]{11})/',
            $videoProfilUrl,
            $ytMatch
        );
        $videoId = $ytMatch[1] ?? null;
    }
@endphp

<section id="video-profil" class="relative py-16 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-forest">
    <img src="{{ asset('images/texture3.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none">

    <div class="relative z-10 max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-cream mb-2">Video Profil Desa Jiwut</h2>
            <div class="w-16 h-1 bg-gold rounded-full mx-auto"></div>
        </div>

        @if ($videoId)
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden border-2 border-cream/20 shadow-lg">
                <iframe
                    class="absolute inset-0 w-full h-full"
                    src="https://www.youtube.com/embed/{{ $videoId }}"
                    title="Video Profil Desa Jiwut"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>

            <a href="{{ $videoProfilUrl }}" target="_blank" rel="noopener"
               class="mt-4 flex items-center gap-4 bg-cream/95 rounded-xl p-4 border border-cream/20 hover:shadow-md transition">
                <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                     alt="Thumbnail Video Profil Desa Jiwut"
                     class="w-32 h-20 object-cover rounded-lg flex-shrink-0">
                <div>
                    <p class="font-heading font-semibold text-brown">Tonton di YouTube</p>
                    <p class="text-sm text-brown/60">Klik untuk membuka video profil Desa Jiwut</p>
                </div>
            </a>
        @else
            <p class="text-center text-cream/70 text-sm">Video profil desa belum tersedia.</p>
            @if (auth()->check() && auth()->user()->role === 'admin')
                <p class="text-center mt-2">
                    <a href="{{ route('admin.profil-desa.edit') }}" class="text-gold text-sm font-semibold hover:underline">
                        Tambahkan link video sekarang
                    </a>
                </p>
            @endif
        @endif
    </div>
</section>

{{-- ================= SEJARAH DESA (cream) ================= --}}
<section id="sejarah" class="relative py-20 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-cream">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto bg-white/95 rounded-2xl p-6 md:p-12 shadow-lg">

        <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-brown mb-2">Sejarah Desa</h2>
        <div class="w-16 h-1 bg-gold rounded-full mb-6"></div>

        @if ($profil->sejarah_intro)
            <p class="text-brown/80 leading-relaxed mb-8">
                {{ $profil->sejarah_intro }}
            </p>
        @endif

        {{-- Asal Usul Dusun --}}
        <h3 class="font-heading font-semibold text-lg text-forest mb-4">Asal Usul Wilayah</h3>

        @if ($dusunList->isEmpty())
            <p class="text-sm text-brown/60 mb-10">Data asal-usul dusun belum ditambahkan.</p>
        @else
            <div class="space-y-4 mb-10">
                @foreach ($dusunList as $d)
                    <div class="flex flex-col sm:flex-row gap-5 bg-forest rounded-xl p-5 border border-brown/10">
                        @if ($d->gambar)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($d->gambar) }}"
                                 alt="Foto {{ $d->nama }}"
                                 class="w-full sm:w-64 h-40 sm:h-auto object-cover rounded-lg flex-shrink-0">
                        @else
                            <div class="w-full sm:w-64 h-40 sm:h-auto rounded-lg flex-shrink-0 bg-cream/10 flex items-center justify-center">
                                <i class="ti ti-photo text-cream/40 text-3xl"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-heading font-semibold text-cream mb-2 flex items-center gap-2">
                                <i class="ti ti-map-pin text-cream"></i> {{ $d->nama }}
                            </p>
                            <p class="text-sm text-cream leading-relaxed">
                                {{ $d->deskripsi }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($profil->sejarah_penutup)
            <p class="text-brown/80 leading-relaxed">
                {!! nl2br(e($profil->sejarah_penutup)) !!}
            </p>
        @endif

    </div>
</section>

{{-- ================= SEJARAH PEMERINTAHAN DESA (hijau) ================= --}}
<section id="sejarah-pemerintahan" class="relative py-20 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-forest">
    <img src="{{ asset('images/texture3.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto bg-white/95 rounded-2xl p-6 md:p-12 shadow-lg">

        <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-brown mb-2">Sejarah Pemerintahan Desa</h2>
        <div class="w-16 h-1 bg-gold rounded-full mb-6"></div>

        @if ($profil->sejarah_pemerintahan_intro)
            <p class="text-brown/80 leading-relaxed mb-5">
                {{ $profil->sejarah_pemerintahan_intro }}
            </p>
        @endif

        {{-- Timeline fase pemerintahan --}}
        @if ($fase->isNotEmpty())
            <div class="relative border-l-2 border-forest/30 ml-4 pl-9 space-y-8 mb-10">
                @foreach ($fase as $i => $f)
                    <div class="relative">
                        <span class="absolute -left-[49px] top-0 w-8 h-8 rounded-full bg-forest text-cream flex items-center justify-center text-sm font-bold ring-4 ring-white">
                            {{ $i + 1 }}
                        </span>
                        <div class="bg-cream/60 rounded-xl p-4 border border-brown/10">
                            <p class="text-xs font-semibold text-gold uppercase tracking-wide mb-1.5">{{ $f->periode }}</p>
                            <p class="text-sm text-brown/80 leading-relaxed">
                                {{ $f->deskripsi }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Tabel Kepala Desa --}}
        <h3 class="font-heading font-semibold text-lg text-forest mb-4">Daftar Kepala Desa Jiwut</h3>
        @if ($kepalaList->isEmpty())
            <p class="text-sm text-brown/60 mb-10">Data kepala desa belum ditambahkan.</p>
        @else
            <div class="overflow-x-auto mb-10 rounded-xl border border-brown/10">
                <table class="w-full text-sm text-left">
                    <thead class="bg-forest text-cream">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Kepala Desa</th>
                            <th class="px-4 py-3">Masa Jabatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brown/10 bg-white">
                        @foreach ($kepalaList as $i => $k)
                            <tr class="{{ $k->is_aktif ? 'bg-gold/10 font-semibold' : '' }}">
                                <td class="px-4 py-3 text-brown/80">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 text-brown">{{ $k->nama }}</td>
                                <td class="px-4 py-3 text-brown/80">{{ $k->masa_jabatan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Tabel Tokoh Berpengaruh --}}
        <h3 class="font-heading font-semibold text-lg text-forest mb-4">Tokoh yang Berpengaruh Terhadap Kemajuan Desa</h3>
        @if ($tokohList->isEmpty())
            <p class="text-sm text-brown/60">Data tokoh belum ditambahkan.</p>
        @else
            <div class="overflow-x-auto rounded-xl border border-brown/10">
                <table class="w-full text-sm text-left">
                    <thead class="bg-forest text-cream">
                        <tr>
                            <th class="px-4 py-3">Nama Tokoh</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Tahun</th>
                            <th class="px-4 py-3">Unsur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brown/10 bg-white">
                        @foreach ($tokohList as $t)
                            <tr>
                                <td class="px-4 py-3 text-brown">{{ $t->nama }}</td>
                                <td class="px-4 py-3 text-brown/70">{{ $t->alamat }}</td>
                                <td class="px-4 py-3 text-brown/70">{{ $t->tahun }}</td>
                                <td class="px-4 py-3 text-brown/70">{{ $t->unsur }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</section>

{{-- ================= KONDISI GEOGRAFIS (cream) ================= --}}
<section id="geografis" class="relative py-20 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-cream">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-brown mb-2">Kondisi Geografis</h2>
            <div class="w-16 h-1 bg-gold rounded-full mx-auto"></div>
        </div>

        {{-- Stat cards luas wilayah --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white rounded-xl p-5 text-center border border-brown/10">
                <p class="font-heading font-extrabold text-2xl text-forest">{{ $geo->luas_total ?? '-' }}</p>
                <p class="text-xs text-brown/70 mt-1">Ha Luas Total</p>
            </div>
            <div class="bg-white rounded-xl p-5 text-center border border-brown/10">
                <p class="font-heading font-extrabold text-2xl text-forest">{{ $geo->luas_sawah ?? '-' }}</p>
                <p class="text-xs text-brown/70 mt-1">Ha Lahan Sawah</p>
            </div>
            <div class="bg-white rounded-xl p-5 text-center border border-brown/10">
                <p class="font-heading font-extrabold text-2xl text-forest">{{ $geo->luas_bukan_sawah ?? '-' }}</p>
                <p class="text-xs text-brown/70 mt-1">Ha Bukan Sawah</p>
            </div>
            <div class="bg-white rounded-xl p-5 text-center border border-brown/10">
                <p class="font-heading font-extrabold text-2xl text-forest">{{ $geo->luas_non_pertanian ?? '-' }}</p>
                <p class="text-xs text-brown/70 mt-1">Ha Non Pertanian</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Info umum --}}
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-brown/10">
                <h3 class="font-heading font-semibold text-lg text-forest mb-4 flex items-center gap-2">
                    Letak &amp; Topografi
                </h3>
                <ul class="space-y-3 text-sm text-brown/80">
                    <li class="flex justify-between gap-4"><span>Koordinat</span><span class="font-medium text-brown">{{ $geo->koordinat ?? '-' }}</span></li>
                    <li class="flex justify-between gap-4"><span>Ketinggian</span><span class="font-medium text-brown">{{ $geo->ketinggian ?? '-' }}</span></li>
                    <li class="flex justify-between gap-4"><span>Topografi</span><span class="font-medium text-brown">{{ $geo->topografi ?? '-' }}</span></li>
                    <li class="flex justify-between gap-4"><span>Curah hujan rata-rata</span><span class="font-medium text-brown">{{ $geo->curah_hujan ?? '-' }}</span></li>
                    <li class="flex justify-between gap-4"><span>Jarak ke kecamatan</span><span class="font-medium text-brown">{{ $geo->jarak_kecamatan ?? '-' }}</span></li>
                    <li class="flex justify-between gap-4"><span>Jarak ke kabupaten</span><span class="font-medium text-brown">{{ $geo->jarak_kabupaten ?? '-' }}</span></li>
                </ul>
            </div>

            {{-- Batas wilayah --}}
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-brown/10">
                <h3 class="font-heading font-semibold text-lg text-forest mb-4 flex items-center gap-2">
                    Batas Wilayah
                </h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-cream/60 rounded-lg p-4 border border-brown/10">
                        <p class="text-xs text-brown/50 mb-1">Utara</p>
                        <p class="text-brown font-medium">{{ $geo->batas_utara ?? '-' }}</p>
                    </div>
                    <div class="bg-cream/60 rounded-lg p-4 border border-brown/10">
                        <p class="text-xs text-brown/50 mb-1">Selatan</p>
                        <p class="text-brown font-medium">{{ $geo->batas_selatan ?? '-' }}</p>
                    </div>
                    <div class="bg-cream/60 rounded-lg p-4 border border-brown/10">
                        <p class="text-xs text-brown/50 mb-1">Barat</p>
                        <p class="text-brown font-medium">{{ $geo->batas_barat ?? '-' }}</p>
                    </div>
                    <div class="bg-cream/60 rounded-lg p-4 border border-brown/10">
                        <p class="text-xs text-brown/50 mb-1">Timur</p>
                        <p class="text-brown font-medium">{{ $geo->batas_timur ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Catatan pertanian --}}
        @if ($geo->catatan_pertanian)
            <div class="bg-white rounded-2xl p-6 md:p-8 mt-6 border border-brown/10">
                <h3 class="font-heading font-semibold text-lg text-forest mb-3 flex items-center gap-2">
                    Pertanian &amp; Pengairan
                </h3>
                <p class="text-sm text-brown/80 leading-relaxed">
                    {{ $geo->catatan_pertanian }}
                </p>
            </div>
        @endif

    </div>
</section>

{{-- ================= BUKU PROFIL DESA (hijau) ================= --}}
@php
    $bukuProfilUrl = $profil->buku_profil_pdf
        ? \Illuminate\Support\Facades\Storage::url($profil->buku_profil_pdf)
        : null;
@endphp

<section id="buku-profil" class="relative py-20 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-forest">
    <img src="{{ asset('images/texture3.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-cream mb-2">Buku Profil Desa Jiwut</h2>
            <div class="w-16 h-1 bg-gold rounded-full mx-auto"></div>
        </div>

        <div class="bg-white/95 rounded-2xl p-6 md:p-10 border border-brown/10 shadow-lg">
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-10">

                {{-- Mockup buku --}}
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/bukuprofil.jpg') }}" alt="Mockup Buku Profil Desa Jiwut"
                         class="w-48 md:w-60 h-auto object-contain drop-shadow-xl">
                </div>

                {{-- Deskripsi & tombol --}}
                <div class="text-center md:text-left">
                    <p class="font-heading font-semibold text-lg text-forest mb-3">
                        Kenali Desa Jiwut Lebih Dekat
                    </p>
                    <p class="text-sm text-brown/70 leading-relaxed mb-6 max-w-xl">
                        Buku Profil Desa Jiwut memuat informasi lengkap seputar sejarah, kondisi
                        geografis, kependudukan, potensi, hingga perkembangan pembangunan Desa Jiwut.
                        Unduh atau baca langsung buku profil desa dalam format PDF berikut ini.
                    </p>

                    @if ($bukuProfilUrl)
                        <a href="{{ $bukuProfilUrl }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 bg-forest hover:bg-[#2A3A1A] text-cream font-heading font-semibold text-sm px-6 py-3 rounded-xl transition">
                            <i class="ti ti-file-type-pdf text-lg"></i>
                            Lihat Buku Profil Desa
                        </a>
                    @else
                        <p class="text-sm text-brown/50 italic">Buku profil desa belum diunggah.</p>
                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.profil-desa.edit') }}"
                               class="inline-flex items-center gap-2 mt-3 text-forest text-sm font-semibold hover:underline">
                                <i class="ti ti-upload"></i> Unggah PDF sekarang
                            </a>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

@endsection