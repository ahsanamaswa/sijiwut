{{-- resources/views/admin/galeri/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Foto Galeri - Admin')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 bg-forest min-h-screen">
    <div class="max-w-2xl mx-auto">

        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-cream">Tambah Foto Galeri</h1>
                <p class="text-sm text-cream/70">Unggah foto baru ke galeri Desa Jiwut</p>
            </div>
            <a href="{{ route('admin.galeri.index') }}"
               class="inline-flex items-center gap-2 bg-cream/10 text-cream border border-cream/30 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/20 transition">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 text-red-100 text-sm rounded-xl p-4 mb-6 border border-red-400/30">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-cream rounded-2xl border border-cream/20 p-6">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="bg-white rounded-2xl p-6 border border-brown/10 space-y-5">

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm text-brown/70 mb-1">Judul</label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                               placeholder="mis. Gotong Royong Bersih Desa" required
                               class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                        @error('judul') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Kategori</label>
                            <input type="text" name="kategori" value="{{ old('kategori') }}"
                                   placeholder="mis. kegiatan, pemandangan, fasilitas" required
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('kategori') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-brown/70 mb-1">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                                   class="w-full rounded-lg border border-brown/20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest/30">
                            @error('tanggal') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="block text-sm text-brown/70 mb-1">Foto</label>
                        <input type="file" name="gambar" accept="image/*" required
                               class="w-full text-sm rounded-lg border border-brown/20 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-forest/30">
                        <p class="text-xs text-brown/50 mt-1">Format JPG/PNG/WEBP, maksimal 4MB.</p>
                        @error('gambar') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.galeri.index') }}"
                       class="inline-flex items-center px-6 py-3 rounded-xl text-sm font-semibold text-brown/70 hover:bg-brown/5 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-forest hover:bg-[#2A3A1A] text-cream font-heading font-semibold text-sm px-6 py-3 rounded-xl transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection