<footer class="bg-brown text-white pt-14 pb-6">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

        <div>
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Desa Jiwut" class="h-12 w-12 object-contain">
                <div>
                    <p class="text-sm leading-tight">Sistem Informasi</p>
                    <p class="font-heading font-bold text-gold text-lg leading-tight">DESA JIWUT</p>
                </div>
            </div>
            <p class="text-sm text-white/70">Kec. Nglegok, Kab. Blitar, Prov. Jawa Timur</p>
            <p class="text-sm text-white/70 mt-2">Jl. Raya Penataran No.1945, Klampok, Jiwut, Nglegok, Blitar, Jawa Timur 66181</p>

            <div class="flex gap-3 mt-5">
                <a href="#" aria-label="Youtube" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <i class="ti ti-brand-youtube"></i>
                </a>
                <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <i class="ti ti-brand-instagram"></i>
                </a>
                <a href="#" aria-label="Tiktok" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <i class="ti ti-brand-tiktok"></i>
                </a>
            </div>
        </div>

        <div>
            <p class="font-heading font-semibold text-gold mb-3">Links</p>
            <ul class="space-y-2 text-sm text-white/80">
                <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                <li><a href="{{ route('tentang-desa') }}" class="hover:text-white">Tentang Desa</a></li>
                <li><a href="{{ route('peta') }}" class="hover:text-white">Peta</a></li>
                <li><a href="{{ route('berita.index') }}" class="hover:text-white">Berita</a></li>
                <li><a href="{{ route('layanan-publik.index') }}" class="hover:text-white">Layanan Publik</a></li>
            </ul>
        </div>

        <div>
            <p class="font-heading font-semibold text-gold mb-3">Hubungi Kami</p>
            <ul class="space-y-2 text-sm text-white/80">
                <li class="flex items-center gap-2"><i class="ti ti-phone"></i> 085704436045</li>
                <li class="flex items-center gap-2"><i class="ti ti-mail"></i> pemdes.jiwut26@gmail.com</li>
            </ul>
        </div>

    </div>

    <div class="border-t border-white/10 mt-10 pt-5 text-center text-xs text-white/50">
        Powered by Kelompok 62 MMD Universitas Brawijaya 2026
    </div>
</footer>