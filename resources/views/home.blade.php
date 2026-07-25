@extends('layouts.app')

@section('title', 'Beranda - Sistem Informasi Desa Jiwut')

@section('content')

{{-- ================= HERO ================= --}}
<section class="relative h-[100vh] min-h-[600px] w-full overflow-hidden">
    <img src="{{ asset('images/gapura.png') }}" alt="Gapura masuk Desa Jiwut"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-forest/90 via-forest/50 to-transparent"></div>

    <div class="relative z-10 h-full flex flex-col justify-center px-6 md:px-20 text-white">
        <p class="text-2xl md:text-3xl font-medium">Sistem Informasi</p>
        <h1 class="font-heading font-extrabold text-5xl md:text-7xl leading-tight -mt-1 text-cream">DESA JIWUT</h1>
        <p class="mt-3 text-base md:text-lg font-medium">Kec. Nglegok, Kab. Blitar, Prov. Jawa Timur</p>
    </div>
</section>

{{-- ================= SAMBUTAN KEPALA DESA ================= --}}
<section class="relative py-20 px-6 md:px-20 bg-cream overflow-hidden">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
        <div>
            <h2 class="font-heading font-extrabold text-3xl md:text-4xl text-brown leading-tight mb-6">
                SAMBUTAN<br>KEPALA DESA JIWUT
            </h2>
            <div class="bg-gradient-to-br from-[#354623] to-[#82AC56] text-cream rounded-2xl p-6 text-base leading-relaxed border-2 border-[#2A1F12]">
                {{-- Ganti teks placeholder ini dengan sambutan asli dari Kepala Desa --}}
                Selamat datang di Website Resmi Desa Jiwut. Kehadiran website ini merupakan wujud dari 
                penyediaan informasi yang terbuka, akurat, dan mudah diakses oleh masyarakat. Melalui website ini, 
                kami berharap masyarakat dapat memperoleh informasi mengenai profil desa, potensi, program, serta 
                berbagai kegiatan yang dilaksanakan di Desa Jiwut. Semoga website ini dapat menjadi sarana komunikasi 
                yang bermanfaat, meningkatkan transparansi penyelenggaraan pemerintahan desa, serta mendukung kemajuan 
                Desa Jiwut menuju desa yang lebih informatif, inovatif, dan sejahtera. Terima kasih atas kunjungan Anda, 
                semoga website ini dapat memberikan manfaat bagi kita semua.
            </div>
        </div>

        <div class="flex justify-center">
            <div class="relative rotate-3">
                <div class="absolute inset-0 -rotate-6 translate-x-3 translate-y-3 bg-gradient-to-br from-[#92724C] to-[#92724C]/40 rounded-2xl"></div>
                <img src="{{ asset('images/foto-kades.png') }}" alt="Foto Kepala Desa Jiwut"
                     class="relative rounded-2xl w-72 md:w-80 object-cover shadow-lg">
            </div>
        </div>
    </div>
</section>

{{-- ================= BERITA DESA ================= --}}
<section class="relative py-20 px-6 md:px-20 bg-[#354623] overflow-hidden">
    <img src="{{ asset('images/texture3.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom kiri: berita unggulan + artikel terkini --}}
        <div class="lg:col-span-2">

            {{-- Berita unggulan --}}
            @if ($beritaUnggulan)
                <a href="{{ route('berita.show', $beritaUnggulan->slug) }}" class="block relative rounded-2xl overflow-hidden group mb-10">
                    <img src="{{ $beritaUnggulan->thumbnail_url }}" alt="{{ $beritaUnggulan->judul }}"
                         class="w-full h-72 object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-brown/90 via-brown/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="text-white font-heading font-bold text-lg md:text-xl leading-snug">
                            {{ $beritaUnggulan->judul }}
                        </h3>
                    </div>
                </a>
            @endif

            {{-- Header Artikel Terkini --}}
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-heading font-bold text-xl text-cream">Berita Desa Terkini</h2>
                <a href="{{ route('berita.index') }}" class="text-sm text-gold font-medium hover:underline flex items-center gap-1">
                    Selengkapnya <i class="ti ti-chevron-right text-sm"></i>
                </a>
            </div>

            {{-- List artikel terkini --}}
            @if ($beritaTerkini->isEmpty())
                <p class="text-cream/70 text-sm">Belum ada berita desa yang dipublikasikan.</p>
            @else
                <div class="space-y-4">
                    @foreach ($beritaTerkini as $berita)
                        <a href="{{ route('berita.show', $berita->slug) }}"
                           class="flex gap-4 bg-cream/90 hover:bg-cream transition rounded-xl p-4 border border-brown/10">
                            <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}"
                                 class="w-24 h-24 rounded-lg object-cover flex-shrink-0">
                            <div>
                                <h3 class="font-heading font-semibold text-brown leading-snug mb-1">{{ $berita->judul }}</h3>
                                <p class="text-sm text-brown/70 mb-2 line-clamp-2">{{ $berita->ringkasan }}</p>
                                <div class="flex flex-wrap gap-4 text-xs text-brown/60">
                                    <span class="flex items-center gap-1"><i class="ti ti-calendar"></i> {{ $berita->tanggal->translatedFormat('d F Y') }}</span>
                                    <span class="flex items-center gap-1"><i class="ti ti-user"></i> {{ $berita->penulis }}</span>
                                    <span class="flex items-center gap-1"><i class="ti ti-bookmark"></i> {{ $berita->kategori }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Kolom kanan: search, peta, menu kategori --}}
        <div class="space-y-6">

            <div class="rounded-xl overflow-hidden border border-brown/10 bg-cream/95">
                <div class="bg-gold/50 text-brown font-heading font-semibold px-4 py-3">Peta Desa</div>
                <iframe
                    src="https://www.google.com/maps?q=Desa+Jiwut,+Kecamatan+Nglegok,+Kabupaten+Blitar&output=embed"
                    width="100%" height="220" style="border:0;" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="rounded-xl overflow-hidden border border-brown/10 bg-cream/95">
                <div class="bg-gold/50 text-brown font-heading font-semibold px-4 py-3 flex items-center gap-2">
                    <i class="ti ti-list"></i> Menu Kategori
                </div>
                <ul class="divide-y divide-brown/10 text-sm">
                    @foreach ($kategoriBerita as $kategori)
                        <li>
                            <a href="{{ route('berita.index') }}" class="block px-4 py-3 text-brown/80 hover:bg-cream hover:text-forest transition">
                                {{ $kategori }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>
</section>

@endsection
