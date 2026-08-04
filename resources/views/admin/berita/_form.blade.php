@php
    $isEdit = isset($berita);
    $old = fn ($key, $default = '') => old($key, $isEdit ? ($berita->{$key} ?? $default) : $default);
@endphp

@if ($errors->any())
    <div class="bg-red-50 text-red-700 text-sm px-4 py-3 rounded-xl mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-brown mb-1.5">Judul Berita</label>
        <input type="text" name="judul" value="{{ $old('judul') }}"
               class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
               placeholder="Contoh: Gotong Royong Perbaikan Jalan Dusun Klampok">
    </div>

    <div>
        <label class="block text-sm font-medium text-brown mb-1.5">Kategori</label>
        <input type="text" name="kategori" value="{{ $old('kategori') }}"
               class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
               placeholder="Contoh: Kegiatan Desa">
    </div>

    <div>
        <label class="block text-sm font-medium text-brown mb-1.5">Tanggal</label>
        <input type="date" name="tanggal"
               value="{{ $old('tanggal') ? \Carbon\Carbon::parse($old('tanggal'))->format('Y-m-d') : '' }}"
               class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40">
    </div>

    <div>
        <label class="block text-sm font-medium text-brown mb-1.5">Penulis</label>
        <input type="text" name="penulis" value="{{ $old('penulis') }}"
               class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
               placeholder="Kosongkan = pakai nama akun kamu">
    </div>

    <div>
        <label class="block text-sm font-medium text-brown mb-1.5">Tag (pisahkan dengan koma)</label>
        <input type="text" name="tags"
               value="{{ $isEdit && is_array($berita->tags) ? implode(', ', $berita->tags) : old('tags') }}"
               class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
               placeholder="Contoh: gotong-royong, infrastruktur">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-brown mb-1.5">Ringkasan Singkat</label>
        <textarea name="ringkasan" rows="2"
                  class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
                  placeholder="Muncul di kartu daftar berita">{{ $old('ringkasan') }}</textarea>
    </div>

    <div class="md:col-span-2 bg-forest/5 border border-forest/20 rounded-xl p-4">
        <label class="block text-sm font-medium text-brown mb-1.5">Link Sumber Luar (opsional)</label>
        <input type="url" name="link_eksternal" value="{{ $old('link_eksternal') }}"
               class="w-full rounded-xl border border-brown/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
               placeholder="https://contoh-media.com/artikel-tentang-desa-jiwut">
        <p class="text-xs text-brown/60 mt-2">
            Isi kalau berita ini sebenarnya liputan dari media/situs lain. Berita akan otomatis masuk
            ke section "Berita dari Sumber Lain" (background hijau) dan pengunjung akan diarahkan ke
            link ini. Kalau kolom "Gambar" di bawah tidak diisi, sistem akan otomatis mengambil foto
            pertama dari halaman tersebut.
        </p>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-brown mb-1.5">Isi Berita</label>

        {{-- input tersembunyi yang benar-benar dikirim ke server --}}
        <input id="konten" type="hidden" name="konten" value="{{ $old('konten') }}">

        {{-- editor visualnya --}}
        <trix-editor input="konten"
                     class="trix-content w-full rounded-xl border border-brown/20 text-sm focus:outline-none focus:ring-2 focus:ring-forest/40"
                     placeholder="Wajib diisi kalau berita BUKAN dari sumber luar"></trix-editor>

        {{-- Toolbar ukuran gambar --}}
        <div class="flex items-center gap-2 mt-2 text-xs flex-wrap">
            <span class="text-brown/60">Klik gambar di atas, lalu atur ukurannya:</span>
            <button type="button" data-resize="300" class="resize-btn px-3 py-1 rounded-full border border-brown/20 text-brown/70 hover:bg-forest/10 disabled:opacity-30 disabled:cursor-not-allowed" disabled>Kecil</button>
            <button type="button" data-resize="500" class="resize-btn px-3 py-1 rounded-full border border-brown/20 text-brown/70 hover:bg-forest/10 disabled:opacity-30 disabled:cursor-not-allowed" disabled>Sedang</button>
            <button type="button" data-resize="700" class="resize-btn px-3 py-1 rounded-full border border-brown/20 text-brown/70 hover:bg-forest/10 disabled:opacity-30 disabled:cursor-not-allowed" disabled>Besar</button>
            <button type="button" data-resize="full" class="resize-btn px-3 py-1 rounded-full border border-brown/20 text-brown/70 hover:bg-forest/10 disabled:opacity-30 disabled:cursor-not-allowed" disabled>Penuh Lebar</button>
        </div>

        <p class="text-xs text-brown/60 mt-2">
            Gunakan tombol gambar di toolbar untuk menyisipkan foto di posisi mana pun dalam teks
            (di atas, di tengah paragraf, maupun di akhir).
        </p>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-brown mb-1.5">Gambar</label>
        @if ($isEdit && $berita->gambar)
            <img src="{{ $berita->thumbnail_url }}" alt="Gambar saat ini" class="w-40 h-28 object-cover rounded-lg mb-3 border border-brown/10">
        @endif
        <input type="file" name="gambar" accept="image/*"
               class="w-full text-sm text-brown/70 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-forest file:text-cream file:text-sm file:font-semibold hover:file:bg-forest/90">
        <p class="text-xs text-brown/60 mt-2">
            Kosongkan kalau tidak ingin mengganti gambar (atau kalau ingin diambil otomatis dari link
            sumber luar di atas).
        </p>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('trix-attachment-add', function (event) {
    const attachment = event.attachment;
    if (attachment.file) {
        const formData = new FormData();
        formData.append('image', attachment.file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch('{{ route("admin.berita.upload-gambar") }}', {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            attachment.setAttributes({
                url: data.url,
                href: data.url,
            });
        })
        .catch(() => {
            attachment.remove();
            alert('Gagal mengunggah gambar. Coba lagi.');
        });
    }
});

// ===== Fitur atur ukuran gambar di dalam editor =====
let currentAttachment = null;

document.addEventListener('trix-selection-change', function (event) {
    const trixEditor = event.target;
    if (!trixEditor.editor) return;

    const range = trixEditor.editor.getSelectedRange();
    const piece = trixEditor.editor.getDocument().getPieceAtPosition(range[0]);

    const resizeButtons = document.querySelectorAll('.resize-btn');

    if (piece && piece.attachment && piece.attachment.getAttribute('contentType')?.startsWith('image')) {
        currentAttachment = piece.attachment;
        resizeButtons.forEach(btn => btn.disabled = false);
    } else {
        currentAttachment = null;
        resizeButtons.forEach(btn => btn.disabled = true);
    }
});

document.querySelectorAll('.resize-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        if (!currentAttachment) return;

        const size = this.dataset.resize;

        if (size === 'full') {
            currentAttachment.setAttributes({ width: null, height: null });
        } else {
            currentAttachment.setAttributes({ width: parseInt(size), height: null });
        }
    });
});
</script>
@endpush