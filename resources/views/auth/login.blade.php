<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-heading font-extrabold text-2xl text-brown mb-1">Login Admin</h1>
        <p class="text-sm text-brown/60">Masuk untuk mengelola konten website Desa Jiwut</p>
    </div>

    {{-- Session status (mis. setelah reset password berhasil) --}}
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-forest bg-cincau/40 border border-forest/20 rounded-lg px-4 py-2.5">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-brown mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="block w-full rounded-lg border border-brown/20 bg-white px-4 py-2.5 text-brown placeholder-brown/40 focus:outline-none focus:ring-2 focus:ring-forest focus:border-forest transition">
            @error('email')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-brown mb-1">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="block w-full rounded-lg border border-brown/20 bg-white px-4 py-2.5 text-brown placeholder-brown/40 focus:outline-none focus:ring-2 focus:ring-forest focus:border-forest transition">
            @error('password')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me + lupa password --}}
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center gap-2 text-brown/70 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-brown/30 text-forest focus:ring-forest">
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-forest hover:underline font-medium">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 bg-forest text-cream px-5 py-3 rounded-full text-sm font-semibold hover:bg-forest/90 transition">
            Login
        </button>
    </form>
</x-guest-layout>