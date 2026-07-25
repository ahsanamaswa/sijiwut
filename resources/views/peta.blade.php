@extends('layouts.app')

@section('title', 'Peta Desa - Sistem Informasi Desa Jiwut')

@section('content')

{{-- ================= HEADER (foto peta desa) ================= --}}
<section class="relative w-full h-[300px] md:h-[380px] overflow-hidden">
    <img src="{{ asset('images/peta.png') }}" alt="Peta Desa Jiwut"
         class="absolute inset-0 w-full h-full object-cover">

    {{-- Overlay gradient animasi --}}
    <div class="absolute inset-0 gradient-animated"></div>

    <div class="relative z-10 h-full flex items-center justify-between px-6 md:px-20">
        <h1 class="font-heading font-extrabold text-4xl md:text-5xl text-cream">Peta Desa Jiwut</h1>

        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.peta.edit') }}"
               class="inline-flex items-center gap-2 bg-cream text-forest px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/90 transition flex-shrink-0">
                <i class="ti ti-pencil"></i> Kelola Informasi Wilayah
            </a>
        @endif
    </div>
</section>

{{-- ================= GOOGLE MAPS ================= --}}
<section class="relative py-16 px-6 md:px-20 overflow-hidden bg-cream">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">
    <div class="relative z-10 max-w-6xl mx-auto">

        <div class="rounded-2xl overflow-hidden border border-brown/10 shadow-lg">
            <div class="bg-forest text-cream font-heading font-semibold px-5 py-3 flex items-center gap-2">
                Lokasi di Google Maps
            </div>
            <iframe
                src="https://www.google.com/maps?q=Desa+Jiwut,+Kecamatan+Nglegok,+Kabupaten+Blitar,+Jawa+Timur&output=embed"
                width="100%" height="420" style="border:0;" loading="lazy" allowfullscreen
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>
</section>

{{-- ================= PETA SKEMATIK 5 DUSUN ================= --}}
<section class="relative py-16 px-6 md:px-20 overflow-hidden bg-[#354623]">
    <img src="{{ asset('images/texture3.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-cream mb-2">Pembagian Wilayah Dusun</h2>
            <div class="w-16 h-1 bg-gold rounded-full mx-auto mb-4"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            {{-- Gambar Peta Wilayah --}}
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="relative">
                    <img src="{{ asset('images/petawilayah.png') }}" alt="Peta skematik pembagian 5 dusun Desa Jiwut" class="w-full h-auto rounded-xl">

                    {{-- Kompas / arah mata angin --}}
                    <div class="absolute top-3 left-3">
                        <svg width="50" height="60" viewBox="0 0 50 60" role="img" aria-label="Arah mata angin Utara">
                            <circle cx="25" cy="30" r="20" fill="#FCF6BA" stroke="#2A1F12" stroke-width="1"/>
                            <path d="M25,14 L30,30 L25,46 L20,30 Z" fill="#2A1F12"/>
                            <text x="25" y="7" text-anchor="middle" font-family="Inter, sans-serif" font-weight="700" font-size="11" fill="#2A1F12">U</text>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Daftar 5 dusun (statis, warna & posisi menyesuaikan gambar peta) --}}
            <div class="space-y-3">
                <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-brown/10">
                    <div class="w-10 h-10 rounded-full bg-[#DF8505] flex-shrink-0"></div>
                    <div>
                        <p class="font-heading font-semibold text-brown">Dusun Darungan</p>
                        <p class="text-xs text-brown/60">Wilayah paling utara Desa Jiwut</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-brown/10">
                    <div class="w-10 h-10 rounded-full bg-[#5D2A82] flex-shrink-0"></div>
                    <div>
                        <p class="font-heading font-semibold text-brown">Dusun Ngrobyong</p>
                        <p class="text-xs text-brown/60">Wilayah timur laut, berbatasan dengan Kelurahan Nglegok</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-brown/10">
                    <div class="w-10 h-10 rounded-full bg-[#D2171B] flex-shrink-0"></div>
                    <div>
                        <p class="font-heading font-semibold text-brown">Dusun Klampok</p>
                        <p class="text-xs text-brown/60">Wilayah tengah, pusat pemukiman utama</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-brown/10">
                    <div class="w-10 h-10 rounded-full bg-[#448A33] flex-shrink-0"></div>
                    <div>
                        <p class="font-heading font-semibold text-brown">Dusun Jiwut</p>
                        <p class="text-xs text-brown/60">Wilayah tengah-selatan, lokasi Balai Desa pertama</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-brown/10">
                    <div class="w-10 h-10 rounded-full bg-[#38ABBA] flex-shrink-0"></div>
                    <div>
                        <p class="font-heading font-semibold text-brown">Dusun Bendil</p>
                        <p class="text-xs text-brown/60">Wilayah paling selatan, gabungan Baran, Sumberjo &amp; Bendil</p>
                    </div>
                </div>

                <a href="{{ route('tentang-desa') }}#sejarah" class="inline-flex items-center gap-1 text-sm text-gold font-medium hover:underline mt-2">
                    Baca asal-usul tiap dusun
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ================= INFORMASI WILAYAH (dari data Geografis, sinkron dengan Tentang Desa) ================= --}}
<section class="relative py-16 px-6 md:px-20 pb-24 overflow-hidden bg-cream">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-brown mb-2">Informasi Wilayah</h2>
            <div class="w-16 h-1 bg-gold rounded-full mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Letak & luas --}}
            <div class="bg-white rounded-2xl p-6 border border-brown/10">
                <h3 class="font-heading font-semibold text-forest mb-4 flex items-center gap-2">
                    Letak Geografis
                </h3>
                <ul class="space-y-2 text-sm text-brown/80">
                    <li class="flex justify-between gap-3"><span>Koordinat</span><span class="font-medium text-brown text-right">{{ $geo->koordinat ?? '-' }}</span></li>
                    <li class="flex justify-between gap-3"><span>Ketinggian</span><span class="font-medium text-brown">{{ $geo->ketinggian ?? '-' }}</span></li>
                    <li class="flex justify-between gap-3"><span>Luas wilayah</span><span class="font-medium text-brown">{{ $geo->luas_total ?? '-' }} Ha</span></li>
                </ul>
            </div>

            {{-- Batas wilayah --}}
            <div class="bg-white rounded-2xl p-6 border border-brown/10">
                <h3 class="font-heading font-semibold text-forest mb-4 flex items-center gap-2">
                    Batas Administratif
                </h3>
                <ul class="space-y-2 text-sm text-brown/80">
                    <li><span class="text-brown/50">Utara</span>: {{ $geo->batas_utara ?? '-' }}</li>
                    <li><span class="text-brown/50">Selatan</span>: {{ $geo->batas_selatan ?? '-' }}</li>
                    <li><span class="text-brown/50">Barat</span>: {{ $geo->batas_barat ?? '-' }}</li>
                    <li><span class="text-brown/50">Timur</span>: {{ $geo->batas_timur ?? '-' }}</li>
                </ul>
            </div>

            {{-- Jarak tempuh --}}
            <div class="bg-white rounded-2xl p-6 border border-brown/10">
                <h3 class="font-heading font-semibold text-forest mb-4 flex items-center gap-2">
                    Jarak Tempuh
                </h3>
                <ul class="space-y-2 text-sm text-brown/80">
                    <li class="flex justify-between gap-3"><span>Ke Kecamatan Nglegok</span><span class="font-medium text-brown">{{ $geo->jarak_kecamatan ?? '-' }}</span></li>
                    <li class="flex justify-between gap-3"><span>Ke Kabupaten Blitar</span><span class="font-medium text-brown">{{ $geo->jarak_kabupaten ?? '-' }}</span></li>
                </ul>
                <a href="{{ route('tentang-desa') }}#geografis" class="inline-flex items-center gap-1 text-sm text-gold font-medium hover:underline mt-4">
                    Detail kondisi geografis
                </a>
            </div>

        </div>
    </div>
</section>

@endsection