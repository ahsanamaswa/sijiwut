<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Analytics (GA4) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4L8HDRV7NT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-4L8HDRV7NT');
    </script>

    <title>@yield('title', 'Sistem Informasi Desa Jiwut')</title>

    <link rel="icon" href="{{ asset('images/logo%20jiwut.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.7/dist/trix.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-forest">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script type="text/javascript" src="https://unpkg.com/trix@2.0.7/dist/trix.umd.min.js"></script>
    @stack('scripts')

</body>
</html>