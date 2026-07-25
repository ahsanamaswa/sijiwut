<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login Admin - Sistem Informasi Desa Jiwut')</title>
    <link rel="icon" href="{{ asset('images/logo%20jiwut.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream min-h-screen">

    <div class="relative min-h-screen flex flex-col items-center justify-center px-6 py-12">

        <div class="relative z-10 w-full max-w-md">
            {{-- Logo & judul --}}
            <div class="flex flex-col items-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/logo%20jiwut.png') }}" alt="Logo Desa Jiwut"
                         class="w-20 h-20 object-contain">
                </a>
                <p class="text-brown/60 text-xs mt-3 tracking-wide uppercase font-semibold">
                    Sistem Informasi Desa Jiwut
                </p>
            </div>

            {{-- Card form --}}
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-brown/10">
                {{ $slot }}
            </div>

            {{-- Kembali ke beranda --}}
            <div class="text-center mt-6">
                <a href="{{ route('home') }}"
                   class="text-brown/60 hover:text-forest text-sm inline-flex items-center gap-1 transition">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>