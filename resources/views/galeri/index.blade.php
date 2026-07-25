@extends('layouts.app')

@section('title', 'Galeri Desa - Sistem Informasi Desa Jiwut')

@section('content')

<div x-data="{ lightboxOpen: false, lightboxSrc: '', lightboxCaption: '' }"
     @keydown.escape.window="lightboxOpen = false">

    {{-- ================= HEADER GALERI ================= --}}
    <section class="relative w-full h-[300px] md:h-[380px] overflow-hidden">
        <img src="{{ asset('images/galeri.png') }}" alt="Gapura Desa Jiwut"
            class="absolute inset-0 w-full h-full object-cover">

        {{-- Overlay gradient animasi --}}
        <div class="absolute inset-0 gradient-animated"></div>

        <div class="relative z-10 h-full flex items-center justify-between px-6 md:px-20">
            <h1 class="font-heading font-extrabold text-4xl md:text-5xl text-cream">Galeri Desa</h1>

            @if (auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.galeri.index') }}"
                   class="inline-flex items-center gap-2 bg-cream text-forest px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/90 transition flex-shrink-0">
                    <i class="ti ti-settings"></i> Kelola Galeri
                </a>
            @endif
        </div>
    </section>

    {{-- ================= FILTER & GRID GALERI ================= --}}
    <section class="relative py-16 px-6 md:px-20 scroll-mt-16 overflow-hidden bg-cream">
        <img src="{{ asset('images/texture.png') }}" alt=""
             class="absolute inset-0 w-full h-full object-cover opacity-100 pointer-events-none">

        <div class="relative z-10 max-w-6xl mx-auto">

            {{-- Filter kategori --}}
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                @foreach ($kategoriList as $kat)
                    <a href="{{ route('galeri.index', $kat === 'semua' ? [] : ['kategori' => $kat]) }}"
                       class="px-5 py-2 rounded-full text-sm font-medium capitalize transition-colors duration-200 border
                              {{ $kategoriAktif === $kat
                                    ? 'bg-forest text-cream border-forest'
                                    : 'bg-white text-brown border-brown/10 hover:bg-brown/5' }}">
                        {{ $kat }}
                    </a>
                @endforeach
            </div>

            {{-- Grid galeri --}}
            @if ($galeri->count())
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                    @foreach ($galeri as $item)
                        <div class="relative group/card">
                            <button type="button"
                                    @click="lightboxOpen = true;
                                            lightboxSrc = '{{ asset('storage/'.$item->gambar) }}';
                                            lightboxCaption = '{{ addslashes($item->judul) }}'"
                                    class="group relative aspect-square rounded-2xl overflow-hidden border border-brown/10 text-left w-full">
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}"
                                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4">
                                    <p class="font-heading font-semibold text-cream text-sm leading-snug">
                                        {{ $item->judul }}
                                    </p>
                                    <p class="text-cream/70 text-xs mt-0.5">
                                        {{ $item->tanggal->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <span class="absolute top-3 right-3 bg-gold text-brown text-[10px] font-semibold uppercase tracking-wide px-2 py-1 rounded-full">
                                    {{ $item->kategori }}
                                </span>
                            </button>

                            @if (auth()->check() && auth()->user()->role === 'admin')
                                <div class="absolute top-3 left-3 flex gap-1.5 opacity-0 group-hover/card:opacity-100 transition-opacity z-10">
                                    <a href="{{ route('admin.galeri.edit', $item) }}"
                                       class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-brown hover:text-forest"
                                       title="Edit foto">
                                        <i class="ti ti-pencil text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-red-600 hover:text-red-700"
                                                title="Hapus foto">
                                            <i class="ti ti-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <p class="text-brown/60 text-sm">Belum ada foto untuk kategori ini.</p>
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('admin.galeri.create') }}" class="inline-block mt-3 text-forest text-sm font-semibold hover:underline">
                            + Tambah foto pertama
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </section>

    {{-- ================= LIGHTBOX ================= --}}
    <div x-show="lightboxOpen"
         x-cloak
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="lightboxOpen = false"
         class="fixed inset-0 z-[60] bg-black/85 backdrop-blur-sm flex items-center justify-center p-6">

        <button type="button"
                @click="lightboxOpen = false"
                aria-label="Tutup"
                class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-cream flex items-center justify-center transition">
            <i class="ti ti-x text-xl"></i>
        </button>

        <div @click.stop class="max-w-3xl w-full">
            <img :src="lightboxSrc" alt="" class="w-full max-h-[75vh] object-contain rounded-xl">
            <p class="text-cream/90 text-center text-sm mt-4 font-heading" x-text="lightboxCaption"></p>
        </div>
    </div>

</div>

@endsection