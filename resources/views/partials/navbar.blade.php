@php
    $menus = [
        'home'            => ['route' => 'home',                 'label' => 'Home'],
        'tentang-desa'    => ['route' => 'tentang-desa',          'label' => 'Tentang Desa'],
        'peta'            => ['route' => 'peta',                  'label' => 'Peta'],
        'galeri'          => ['route' => 'galeri.index',          'label' => 'Galeri Desa'],
        'berita'          => ['route' => 'berita.index',          'label' => 'Berita'],
    ];
@endphp

<nav x-data="{ mobileOpen: false, scrolled: false }"
     x-init="scrolled = window.scrollY > 40"
     @scroll.window="scrolled = window.scrollY > 40"
     @keydown.escape.window="mobileOpen = false"
     :class="scrolled ? 'bg-brown/70 backdrop-blur-md shadow-md' : 'bg-transparent'"
     class="fixed top-0 left-0 right-0 z-50 flex items-center px-6 md:px-10 py-4 transition-colors duration-300">

    {{-- ===== Logo ===== --}}
    @if (request()->routeIs('home'))
        @guest
            <a href="{{ route('login') }}" title="Login Admin">
                <img src="{{ asset('images/logo%20jiwut.png') }}" alt="Logo Desa Jiwut" class="h-12 w-12 object-contain">
            </a>
        @else
            <img src="{{ asset('images/logo%20jiwut.png') }}" alt="Logo Desa Jiwut" class="h-12 w-12 object-contain">
        @endguest
    @else
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo%20text.png') }}" alt="Logo Desa Jiwut" class="h-10 md:h-12 object-contain">
        </a>
    @endif

    {{-- ===== Grup kanan (menu desktop + logout + hamburger) ===== --}}
    <div class="flex items-center gap-2 ml-auto">

        {{-- Menu Desktop --}}
        <div class="hidden md:flex gap-1 bg-black/10 backdrop-blur-sm rounded-full p-1">
            @foreach ($menus as $menu)
                <a href="{{ route($menu['route']) }}"
                   class="px-5 py-2 rounded-full text-sm font-medium transition-colors duration-200
                          {{ request()->routeIs($menu['route'].'*')
                                ? 'bg-cream text-brown'
                                : 'text-white hover:bg-white/10' }}">
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Indikator Logout (muncul di semua halaman kalau admin login) --}}
        @auth
            @if (auth()->user()->role === 'admin')
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-10 h-10 rounded-full bg-red-600 border border-red-700 text-white flex items-center justify-center hover:bg-red-700 hover:border-red-800 transition duration-200 flex-shrink-0"
                            title="Logout">
                        <i class="ti ti-door-exit text-lg"></i>
                    </button>
                </form>
            @endif
        @endauth

        {{-- Tombol Hamburger (mobile) --}}
        <button type="button"
                @click="mobileOpen = !mobileOpen"
                aria-label="Buka menu"
                :aria-expanded="mobileOpen"
                class="md:hidden relative z-50 w-10 h-10 flex flex-col items-center justify-center gap-1.5
                       bg-black/10 backdrop-blur-sm rounded-full flex-shrink-0">
            <span class="block w-5 h-0.5 bg-white rounded-full transition-all duration-300"
                  :class="mobileOpen ? 'rotate-45 translate-y-2' : ''"></span>
            <span class="block w-5 h-0.5 bg-white rounded-full transition-all duration-300"
                  :class="mobileOpen ? 'opacity-0' : 'opacity-100'"></span>
            <span class="block w-5 h-0.5 bg-white rounded-full transition-all duration-300"
                  :class="mobileOpen ? '-rotate-45 -translate-y-2' : ''"></span>
        </button>

    </div>

    {{-- ===== Overlay ===== --}}
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="md:hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-40"></div>

    {{-- ===== Panel Menu Mobile ===== --}}
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden fixed top-[76px] left-4 right-4 z-50 bg-cream rounded-2xl shadow-lg p-3">
        <div class="flex flex-col gap-1">
            @foreach ($menus as $menu)
                <a href="{{ route($menu['route']) }}"
                   @click="mobileOpen = false"
                   class="px-4 py-3 rounded-xl text-sm font-medium transition-colors duration-200
                          {{ request()->routeIs($menu['route'].'*')
                                ? 'bg-forest text-cream'
                                : 'text-brown hover:bg-brown/5' }}">
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>
    </div>

</nav>