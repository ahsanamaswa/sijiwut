@extends('layouts.app')

@section('title', 'Edit Berita - Admin')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 bg-cream min-h-screen">
    <div class="max-w-4xl mx-auto">

        <div class="flex items-center gap-2 text-xs text-brown/60 mb-6">
            <a href="{{ route('admin.berita.index') }}" class="hover:text-forest transition">Kelola Berita</a>
            <i class="ti ti-chevron-right text-[10px]"></i>
            <span class="text-brown">Edit Berita</span>
        </div>

        <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-brown mb-8">Edit Berita</h1>

        <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-brown/10 p-6 md:p-8">
            @csrf
            @method('PUT')

            @include('admin.berita._form')

            <div class="flex items-center gap-3 mt-8">
                <button type="submit"
                        class="bg-forest text-cream px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-forest/90 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.berita.index') }}" class="text-sm text-brown/60 hover:text-brown">Batal</a>
            </div>
        </form>

    </div>
</section>
@endsection
