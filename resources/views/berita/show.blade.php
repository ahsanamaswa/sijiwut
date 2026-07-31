@extends('layouts.app')

@section('title', $berita->judul.' - Sistem Informasi Desa Jiwut')

@section('content')

<section class="relative pt-32 pb-4 px-6 md:px-20 bg-cream">
    {{-- Breadcrumb --}}
    <div class="max-w-6xl mx-auto flex items-center gap-2 text-xs text-brown/60 mb-6 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-forest transition">Home</a>
        <i class="ti ti-chevron-right text-[10px]"></i>
        <a href="{{ route('berita.index') }}" class="hover:text-forest transition">Berita</a>
        <i class="ti ti-chevron-right text-[10px]"></i>
        <span class="text-brown">{{ $berita->judul }}</span>
    </div>

    <div class="max-w-6xl mx-auto">
        <h1 class="font-heading font-extrabold text-2xl md:text-4xl text-brown leading-snug mb-8">
            {{ $berita->judul }}
        </h1>
    </div>
</section>

<section class="relative pb-20 px-6 md:px-20 bg-cream">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[220px_1fr_320px] gap-8">

        {{-- ===== Meta kiri ===== --}}
        <aside class="flex lg:flex-col gap-4 lg:gap-5 flex-wrap text-sm text-brown/70 order-2 lg:order-1">
            <div class="flex items-center gap-2">
                <i class="ti ti-calendar text-forest"></i>
                {{ $berita->tanggal->translatedFormat('d F Y') }}
            </div>
            <div class="flex items-center gap-2">
                <i class="ti ti-folder text-forest"></i>
                {{ $berita->kategori }}
            </div>
            @if (! empty($berita->tags))
                <div class="flex items-center gap-2 flex-wrap">
                    <i class="ti ti-tag text-forest"></i>
                    @foreach ($berita->tags as $tag)
                        <span class="bg-forest/10 text-forest text-xs px-2 py-0.5 rounded-full">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif
            <div class="flex items-center gap-2">
                <i class="ti ti-user text-forest"></i>
                {{ $berita->penulis }}
            </div>
            <div class="flex items-center gap-2">
                <i class="ti ti-chart-bar text-forest"></i>
                Post Views: {{ $berita->views }}
            </div>
        </aside>

        {{-- ===== Konten utama ===== --}}
        <article class="order-1 lg:order-2">
            <figure class="mb-3">
                <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}"
                     class="w-full h-64 md:h-80 object-cover rounded-2xl border border-brown/10">
                <figcaption class="text-xs text-brown/50 mt-2">
                    {{ $berita->ringkasan }}
                </figcaption>
            </figure>

            <div class="trix-content prose prose-sm md:prose-base max-w-none text-brown/80 leading-relaxed">
                @if ($berita->konten)
                    {!! $berita->konten !!}
                @else
                    <p>{{ $berita->ringkasan }}</p>
                @endif
            </div>

            @if (auth()->check() && auth()->user()->role === 'admin')
                <div class="flex items-center gap-3 mt-8 pt-6 border-t border-brown/10">
                    <a href="{{ route('admin.berita.edit', $berita) }}"
                       class="inline-flex items-center gap-2 bg-forest text-cream px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-forest/90 transition">
                        <i class="ti ti-pencil"></i> Edit Berita
                    </a>
                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                          onsubmit="return confirm('Hapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-red-50 text-red-600 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-red-100 transition">
                            <i class="ti ti-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            @endif
        </article>

        {{-- ===== Sidebar Berita Lainnya ===== --}}
        <aside class="order-3">
            <div class="bg-forest text-cream rounded-xl px-4 py-3 flex items-center gap-2 mb-4">
                <i class="ti ti-news"></i>
                <span class="font-heading font-semibold text-sm uppercase tracking-wide">Berita Lainnya</span>
            </div>

            <div class="flex flex-col gap-4">
                @foreach ($lainnya as $item)
                    @php
                        $href = $item->is_external ? $item->link_eksternal : route('berita.show', $item->slug);
                    @endphp
                    <a href="{{ $href }}" @if($item->is_external) target="_blank" rel="noopener" @endif
                       class="group flex gap-3 bg-white rounded-xl p-3 border border-brown/10 hover:shadow-md transition-shadow">
                        <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul }}"
                             loading="lazy"
                             class="w-20 h-16 object-cover rounded-lg flex-shrink-0">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-brown leading-snug line-clamp-2 group-hover:text-forest transition-colors">
                                {{ $item->judul }}
                            </p>
                            <p class="text-xs text-brown/50 mt-1">
                                {{ $item->tanggal->format('d/m/Y') }} | {{ $item->kategori }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </aside>

    </div>
</section>

@endsection