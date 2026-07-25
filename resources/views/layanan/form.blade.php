@extends('layouts.app')

@section('title', 'Form Pengajuan - Sistem Informasi Desa Jiwut')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 max-w-4xl mx-auto">
    <h1 class="font-heading font-extrabold text-3xl text-cream mb-4">Form pengajuan: {{ $jenis }}</h1>

    <form method="POST" action="{{ route('layanan-publik.store', $jenis) }}" class="space-y-4 max-w-md">
        @csrf
        <div>
            <label class="block text-sm text-cream/80 mb-1">Nama lengkap</label>
            <input type="text" name="nama" required class="w-full">
        </div>
        <div>
            <label class="block text-sm text-cream/80 mb-1">NIK</label>
            <input type="text" name="nik" required class="w-full">
        </div>
        <button type="submit">Kirim pengajuan</button>
    </form>
</section>
@endsection