@extends('layouts.app')

@section('title', 'Berita - Sistem Informasi Desa Jiwut')

@section('content')

{{-- ===================== HEADER BERITA (hero image + gradient berjalan) ===================== --}}
<section class="relative w-full h-[300px] md:h-[380px] overflow-hidden">
    <img src="{{ asset('images/berita.png') }}" alt="Berita Desa Jiwut"
         class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 gradient-animated"></div>

    <div class="relative z-10 h-full flex flex-col justify-center px-6 md:px-20">
        <div class="max-w-6xl mx-auto w-full">
            <div class="flex items-center gap-2 text-xs text-cream/70 mb-4">
                <a href="{{ route('home') }}" class="hover:text-cream transition">Beranda</a>
                <i class="ti ti-chevron-right text-[10px]"></i>
                <span class="text-cream">Berita</span>
            </div>

            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="font-heading font-extrabold text-3xl md:text-5xl text-cream mb-2">Berita Desa Jiwut</h1>
                    <p class="text-cream/80 max-w-2xl">
                        Kabar terbaru seputar kegiatan, program, dan perkembangan Desa Jiwut.
                    </p>
                </div>

                @if (auth()->check() && auth()->user()->role === 'admin')
                    <div class="flex items-center gap-2.5 flex-shrink-0">
                        <a href="{{ route('admin.berita.create') }}"
                           class="inline-flex items-center gap-2 bg-cream text-forest px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/90 transition">
                            <i class="ti ti-plus"></i> Tambah Berita
                        </a>
                        <a href="{{ route('admin.berita.index') }}"
                           class="inline-flex items-center gap-2 bg-cream/10 text-cream border border-cream/30 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/20 transition">
                            <i class="ti ti-settings"></i> Kelola Berita
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ===================== BERITA DESA (cream) ===================== --}}
<section class="relative py-14 px-6 md:px-20 bg-cream">
    <img src="{{ asset('images/texture.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-full bg-forest text-cream flex items-center justify-center flex-shrink-0">
                <i class="ti ti-building-community text-lg"></i>
            </div>
            <div>
                <h2 class="font-heading font-extrabold text-xl md:text-2xl text-brown">Berita Desa</h2>
                <p class="text-sm text-brown/60">Kegiatan dan program yang dipublikasikan langsung oleh Desa Jiwut</p>
            </div>
        </div>

        @if ($beritaInternal->isEmpty())
            <p class="text-brown/60 py-10">Belum ada berita desa yang dipublikasikan.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($beritaInternal as $item)
                    <div class="relative group/card">
                        <a href="{{ route('berita.show', $item->slug) }}"
                           class="group bg-white rounded-2xl overflow-hidden border border-brown/10 hover:shadow-lg transition-shadow flex flex-col">

                            <div class="relative h-44 overflow-hidden bg-brown/5">
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="absolute top-3 left-3 bg-forest text-cream text-[11px] font-semibold px-3 py-1 rounded-full">
                                    {{ $item->kategori }}
                                </span>
                            </div>

                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs text-brown/50 mb-2">
                                    {{ $item->tanggal->translatedFormat('d F Y') }}
                                </p>
                                <h3 class="font-heading font-bold text-brown text-base leading-snug mb-2 group-hover:text-forest transition-colors">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-sm text-brown/70 leading-relaxed line-clamp-3 flex-1">
                                    {{ $item->ringkasan }}
                                </p>
                                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-forest">
                                    Baca Selengkapnya
                                    <i class="ti ti-arrow-right text-base group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </div>
                        </a>

                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <div class="absolute top-3 right-3 flex gap-1.5 opacity-0 group-hover/card:opacity-100 transition-opacity">
                                <a href="{{ route('admin.berita.edit', $item) }}"
                                   class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-brown hover:text-forest"
                                   title="Edit berita">
                                    <i class="ti ti-pencil text-sm"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-red-600 hover:text-red-700"
                                            title="Hapus berita">
                                        <i class="ti ti-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ================= BERITA DARI SUMBER LAIN (hijau) ================= --}}
<section class="relative py-14 px-6 md:px-20 overflow-hidden bg-forest">
    <img src="{{ asset('images/texture3.png') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover opacity-100 mix-blend-overlay pointer-events-none">

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-full bg-cream/95 text-forest flex items-center justify-center flex-shrink-0">
                <i class="ti ti-world text-lg"></i>
            </div>
            <div>
                <h2 class="font-heading font-extrabold text-xl md:text-2xl text-cream">Berita dari Sumber Lain</h2>
                <p class="text-sm text-cream/70">Liputan tentang Desa Jiwut dari media atau institusi luar</p>
            </div>
        </div>

        @if ($beritaEksternal->isEmpty())
            <p class="text-cream/70 py-10">Belum ada liputan dari sumber luar.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($beritaEksternal as $item)
                    <div class="relative group/card">
                        <a href="{{ $item->link_eksternal }}" target="_blank" rel="noopener"
                           class="group bg-cream/95 rounded-2xl overflow-hidden border border-cream/20 hover:shadow-lg transition-shadow flex flex-col">

                            <div class="relative h-44 overflow-hidden bg-brown/5">
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="absolute top-3 left-3 bg-forest text-cream text-[11px] font-semibold px-3 py-1 rounded-full">
                                    {{ $item->kategori }}
                                </span>
                                <span class="absolute top-3 right-3 bg-white/95 text-brown text-[11px] font-semibold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <i class="ti ti-external-link text-xs"></i> Sumber Luar
                                </span>
                            </div>

                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs text-brown/50 mb-2">
                                    {{ $item->tanggal->translatedFormat('d F Y') }}
                                </p>
                                <h3 class="font-heading font-bold text-brown text-base leading-snug mb-2 group-hover:text-forest transition-colors">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-sm text-brown/70 leading-relaxed line-clamp-3 flex-1">
                                    {{ $item->ringkasan }}
                                </p>
                                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-forest">
                                    Baca di sumber asli
                                    <i class="ti ti-external-link text-base group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </div>
                        </a>

                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <div class="absolute flex gap-1.5 opacity-0 group-hover/card:opacity-100 transition-opacity"
                                 style="top: 3.25rem; right: 0.75rem;">
                                <a href="{{ route('admin.berita.edit', $item) }}"
                                   class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-brown hover:text-forest"
                                   title="Edit berita">
                                    <i class="ti ti-pencil text-sm"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-red-600 hover:text-red-700"
                                            title="Hapus berita">
                                        <i class="ti ti-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection