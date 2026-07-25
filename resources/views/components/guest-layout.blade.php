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
<body class="bg-forest min-h-screen">

    <div class="relative min-h-screen flex flex-col items-center justify-center px-6 py-12 overflow-hidden">
        <img src="{{ asset('images/texture.png') }}" alt=""
             class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-overlay pointer-events-none">

        <div class="relative z-10 w-full max-w-md">
            {{-- Logo & judul --}}
            <div class="flex flex-col items-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/logo jiwut.png') }}" alt="Logo Desa Jiwut"
                         class="w-16 h-16 object-contain">
                </a>
                <p class="text-cream/70 text-xs mt-3 tracking-wide uppercase">
                    Sistem Informasi Desa Jiwut
                </p>
            </div>

            {{-- Card form --}}
            <div class="bg-cream rounded-2xl shadow-xl p-8">
                {{ $slot }}
            </div>

            {{-- Kembali ke beranda --}}
            <div class="text-center mt-6">
                <a href="{{ route('home') }}"
                   class="text-cream/70 hover:text-cream text-sm inline-flex items-center gap-1 transition">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>