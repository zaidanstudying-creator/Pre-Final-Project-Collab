<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-[#F5F6FA] min-h-screen">

    {{-- Header Admin Moderasi --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-8 mb-8 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-gray-900 rounded-full">Dashboard Admin</span>
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-[#FF500A] bg-orange-100 rounded-full flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#FF500A] animate-pulse"></span>
                    {{ $books->count() }} Antrean
                </span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Moderasi Karya</h1>
            <p class="text-sm font-semibold text-gray-500 mt-2">Tinjau naskah penulis, periksa kelayakan konten, dan setujui untuk publikasi.</p>
        </div>

        {{-- Tombol Navigasi ke Kategori --}}
        <div class="shrink-0 mt-4 sm:mt-0">
            <a href="{{ route('admin.categories.index') }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-full text-sm transition-all shadow-sm border border-gray-200">
                <svg class="w-4 h-4 mr-2 text-[#FF500A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Kelola Kategori Genre
            </a>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Buku Menunggu Moderasi --}}
    @if ($books->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6 text-gray-300 border border-gray-200">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">Antrean Kosong</h3>
            <p class="text-sm font-medium text-gray-500 max-w-sm">Tidak ada naskah baru yang menunggu untuk ditinjau saat ini. Kerja bagus, Admin!</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($books as $book)
                <article wire:key="book-{{ $book->id }}" class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-md">

                    {{-- DI SINI PERBAIKANNYA: Menggunakan Flexbox alih-alih Grid --}}
                    <div class="flex flex-col lg:flex-row">

                        {{-- Cover Image --}}
                        <div class="w-full lg:w-[260px] shrink-0 bg-gray-50 border-b lg:border-b-0 lg:border-r border-gray-200 p-6 flex flex-col items-center justify-start">
                            <div class="w-40 lg:w-full aspect-[2/3] rounded-lg overflow-hidden shadow-md border border-gray-200">
                                @if ($book->cover_image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul" class="w-full h-full object-cover">
                                @else
                                    <div class="flex w-full h-full items-center justify-center bg-gray-200 text-gray-400">
                                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Konten Review --}}
                        <div class="flex-1 min-w-0 p-6 lg:p-8 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="text-xs font-black uppercase tracking-wider text-[#FF500A]">{{ $book->category?->name ?? 'Tanpa kategori' }}</span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span class="text-xs font-semibold text-gray-500">Penulis: <a href="{{ route('profile', $book->user?->id) }}" target="_blank" class="text-gray-900 font-bold hover:text-[#FF500A] underline decoration-2 underline-offset-2">{{ $book->user?->name ?? 'Anonim' }}</a></span>
                                </div>

                                {{-- truncate agar judul panjang tidak merusak layout --}}
                                <h2 class="text-2xl font-black text-gray-900 leading-tight mb-4 truncate">{{ $book->title }}</h2>

                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 mb-6">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Sinopsis</h4>
                                    {{-- line-clamp-4 agar sinopsis dibatasi maksimal 4 baris --}}
                                    <p class="text-sm leading-relaxed text-gray-700 whitespace-pre-line line-clamp-4">{{ $book->synopsis }}</p>
                                </div>

                                {{-- Daftar Bab Review --}}
                                @if ($book->chapters->isNotEmpty())
                                    <div class="mb-8">
                                        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-3 flex items-center justify-between">
                                            <span>Pratinjau Bab ({{ $book->chapters->count() }} Bab)</span>
                                        </h4>
                                        <ul class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
                                            @foreach ($book->chapters->take(6) as $chapter)
                                                <li class="flex items-center gap-3 text-sm text-gray-700 bg-white border border-gray-200 p-3 rounded-xl shadow-sm">
                                                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 shrink-0">{{ $chapter->chapter_number }}</span>
                                                    <span class="truncate font-semibold">{{ $chapter->title }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if ($book->chapters->count() > 6)
                                            <p class="mt-3 text-xs font-semibold text-gray-400 text-center">...dan {{ $book->chapters->count() - 6 }} bab lainnya disembunyikan.</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-xl">
                                        <p class="text-sm font-bold text-rose-600">⚠️ Perhatian: Penulis belum menambahkan bab sama sekali.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100 mt-auto">
                                <button type="button" wire:click="approve({{ $book->id }})" wire:loading.attr="disabled"
                                    class="flex-1 inline-flex items-center justify-center px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-full transition-all shadow-sm shadow-emerald-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Setujui & Publikasikan
                                </button>
                                <button type="button" wire:click="startReject({{ $book->id }})"
                                    class="flex-1 inline-flex items-center justify-center px-8 py-3.5 bg-white border-2 border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 text-sm font-bold rounded-full transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Tolak / Minta Revisi
                                </button>
                            </div>
                        </div>

                    </div>
                </article>
            @endforeach
        </div>
    @endif

    {{-- Modal Penolakan (Pop-up) Minimalis --}}
    @if ($rejectingBookId)
        <div class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-gray-900/60 backdrop-blur-sm p-4 transition-opacity" role="dialog" aria-modal="true" wire:key="reject-modal-{{ $rejectingBookId }}">

            <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <div>
                        <h2 class="text-xl font-black text-gray-900">Minta Revisi Naskah</h2>
                        <p class="text-xs font-semibold text-gray-500 mt-1">Berikan alasan jelas agar penulis bisa memperbaiki karyanya.</p>
                    </div>
                    <button type="button" wire:click="closeRejectForm" class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit="reject" class="p-8">
                    <div>
                        <label for="adminNotes" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Catatan Evaluasi / Alasan Penolakan</label>
                        <textarea id="adminNotes" wire:model="adminNotes" rows="5" minlength="10" required
                            class="block w-full rounded-xl border-gray-300 bg-white p-4 text-sm font-medium text-gray-900 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-colors resize-none shadow-sm"
                            placeholder="Contoh: Tolong perbaiki format paragraf di Bab 1 dan perjelas sinopsisnya..."></textarea>
                        @error('adminNotes') <span class="mt-2 text-xs font-bold text-rose-500 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <button type="button" wire:click="closeRejectForm" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Batal</button>
                        <button type="submit" wire:loading.attr="disabled" class="px-8 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-full text-sm font-bold transition-all shadow-sm shadow-rose-200 flex items-center gap-2">
                            <span wire:loading.remove wire:target="reject">Kirim & Tolak Naskah</span>
                            <span wire:loading wire:target="reject">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    @endif
</div>
