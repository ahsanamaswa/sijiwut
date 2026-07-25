@extends('layouts.app')

@section('title', 'Layanan Publik - Sistem Informasi Desa Jiwut')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 max-w-4xl mx-auto">
    <h1 class="font-heading font-extrabold text-3xl text-cream mb-4">Layanan Publik</h1>

    @if (session('success'))
        <div class="bg-cream/15 text-cream text-sm rounded-lg px-4 py-3 mb-4 border border-cream/30">
            {{ session('success') }}
        </div>
    @endif

    <p class="text-cream/80">Halaman ini masih placeholder — nanti tampilkan daftar jenis surat (KTP, KK, domisili, SKTM) di sini.</p>
</section>
@endsection