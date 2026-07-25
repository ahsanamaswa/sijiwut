@extends('layouts.app')

@section('title', 'Kelola Berita - Admin')

@section('content')
<section class="pt-32 pb-20 px-6 md:px-20 bg-forest min-h-screen">
    <div class="max-w-6xl mx-auto">

        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-cream">Kelola Berita</h1>
                <p class="text-sm text-cream/70">Tambah, edit, atau hapus berita Desa Jiwut</p>
            </div>
            <a href="{{ route('admin.berita.create') }}"
               class="inline-flex items-center gap-2 bg-cream text-forest px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-cream/90 transition">
                <i class="ti ti-plus"></i> Tambah Berita
            </a>
        </div>

        @if (session('status'))
            <div class="bg-cream/10 text-cream text-sm px-4 py-3 rounded-xl mb-6 border border-cream/20">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-cream rounded-2xl border border-cream/20 overflow-hidden overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-brown/5 text-brown/70">
                    <tr>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Sumber</th>
                        <th class="px-4 py-3 text-center">Unggulan</th>
                        <th class="px-4 py-3">Views</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brown/10">
                    @forelse ($berita as $item)
                        <tr class="{{ $item->unggulan ? 'bg-gold/10' : '' }}">
                            <td class="px-4 py-3 text-brown font-medium max-w-xs truncate">{{ $item->judul }}</td>
                            <td class="px-4 py-3 text-brown/70">{{ $item->kategori }}</td>
                            <td class="px-4 py-3 text-brown/70">{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                @if ($item->is_external)
                                    <span class="bg-forest/10 text-forest text-xs px-2 py-1 rounded-full">Sumber Luar</span>
                                @else
                                    <span class="bg-gold/20 text-brown text-xs px-2 py-1 rounded-full">Berita Desa</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($item->is_external)
                                    <span class="text-brown/30" title="Berita sumber luar tidak bisa dijadikan unggulan">—</span>
                                @elseif ($item->unggulan)
                                    <span class="inline-flex items-center gap-1 bg-gold text-brown text-xs font-semibold px-2.5 py-1 rounded-full"
                                          title="Ini berita unggulan saat ini">
                                        <i class="ti ti-star-filled text-sm"></i> Unggulan
                                    </span>
                                @else
                                    <form action="{{ route('admin.berita.set-unggulan', $item) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 bg-brown/5 text-brown/40 hover:bg-gold/20 hover:text-brown text-xs font-medium px-2.5 py-1 rounded-full transition"
                                                title="Jadikan berita unggulan (menggantikan yang sekarang)">
                                            <i class="ti ti-star text-sm"></i> Jadikan
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-brown/70">{{ $item->views }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.berita.edit', $item) }}"
                                       class="text-forest hover:underline text-sm">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-brown/50">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $berita->links() }}
        </div>

    </div>
</section>
@endsection