@extends('layouts.app')

@section('title', 'Kelola Galeri - Admin')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 bg-forest min-h-screen">
    <div class="max-w-6xl mx-auto">

        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-cream">Kelola Galeri Desa</h1>
                <p class="text-sm text-cream/70">Tambah, edit, atau hapus foto galeri Desa Jiwut</p>
            </div>
            <a href="{{ route('admin.galeri.create') }}"
               class="inline-flex items-center gap-2 bg-cream text-forest px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/90 transition">
                <i class="ti ti-plus"></i> Tambah Foto
            </a>
        </div>

        @if (session('success'))
            <div class="bg-cream/10 text-cream text-sm px-4 py-3 rounded-xl mb-6 border border-cream/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-cream rounded-2xl border border-cream/20 p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse ($galeri as $item)
                    <div class="bg-white rounded-xl overflow-hidden border border-brown/10">
                        <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-32 object-cover">
                        <div class="p-3">
                            <p class="font-semibold text-sm text-brown line-clamp-1">{{ $item->judul }}</p>
                            <p class="text-xs text-brown/60">{{ $item->kategori }} · {{ $item->tanggal->format('d/m/Y') }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <a href="{{ route('admin.galeri.edit', $item) }}"
                                   class="text-forest hover:underline text-xs font-semibold">Edit</a>
                                <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus foto ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 md:col-span-4 py-10 text-center text-brown/50">
                        Belum ada foto galeri.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $galeri->links() }}
        </div>

    </div>
</section>
@endsection