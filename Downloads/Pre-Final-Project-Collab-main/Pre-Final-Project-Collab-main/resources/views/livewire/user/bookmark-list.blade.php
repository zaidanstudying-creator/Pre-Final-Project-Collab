<div class="bg-[#F5F6FA] min-h-screen py-8">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Bookmark --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-gray-200">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-[#FF500A] bg-orange-50 rounded shadow-sm">Rak Pribadi</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">Koleksi Bacaan</h1>
                <p class="text-sm font-semibold text-gray-500 mt-1">Daftar cerita favorit yang kamu simpan untuk dibaca nanti.</p>
            </div>

            <div class="shrink-0 flex items-center gap-4">
                <span class="text-sm font-bold text-gray-400 hidden sm:block">
                    Total: {{ $books->count() }} Buku
                </span>
                <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center px-6 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Buku Lain
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl text-sm font-bold flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Konten Rak --}}
        @if ($books->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300 border border-gray-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Rak Bukumu Kosong</h3>
                <p class="text-sm font-medium text-gray-500 max-w-sm mb-6">Jelajahi katalog Weboo, temukan cerita menarik, lalu simpan ke rak ini.</p>
                <a href="{{ route('home') }}" wire:navigate class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-full text-sm transition-colors shadow-sm">
                    Eksplorasi Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach ($books as $book)
                    <article wire:key="bookmark-{{ $book->id }}" class="group flex flex-col">

                        {{-- Cover Buku (Rasio 2:3 Wattpad) --}}
                        <a href="{{ route('book.detail', $book->slug ?? $book->id) }}" wire:navigate class="relative aspect-[2/3] rounded-lg shadow-sm overflow-hidden mb-3 border border-gray-200 block">
                            @if ($book->cover_image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul {{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-300">
                                    <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">No Cover</span>
                                </div>
                            @endif

                            {{-- Label Kategori Melayang --}}
                            <div class="absolute top-2 left-2 px-2 py-0.5 text-[9px] font-black uppercase tracking-wider text-white bg-black/60 backdrop-blur-sm rounded">
                                {{ $book->category?->name ?? 'Umum' }}
                            </div>
                        </a>

                        {{-- Info & Tombol Hapus --}}
                        <div class="flex flex-col flex-grow">
                            <a href="{{ route('book.detail', $book->slug ?? $book->id) }}" wire:navigate>
                                <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-2 group-hover:text-[#FF500A] transition-colors mb-1" title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h3>
                            </a>

                            {{-- Tombol Keluarkan dari Rak --}}
                            <div class="mt-auto pt-2">
                                <button type="button" wire:click="remove({{ $book->id }})" wire:confirm="Hapus {{ $book->title }} dari rak bacaan?" wire:loading.attr="disabled"
                                    class="w-full flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-gray-400 hover:border-rose-200 hover:text-rose-600 hover:bg-rose-50 text-[10px] font-bold uppercase tracking-widest rounded transition-colors shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span wire:loading.remove wire:target="remove({{ $book->id }})">Hapus</span>
                                    <span wire:loading wire:target="remove({{ $book->id }})">...</span>
                                </button>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>
        @endif

    </div>
</div>
