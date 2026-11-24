<div class="bg-[#F9FAFB] min-h-screen py-8 md:py-12 font-sans">

    {{-- Lebar kontainer sengaja dibuat lebih sempit (max-w-3xl) agar mata tidak lelah membaca dari ujung ke ujung --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Navigasi Atas (Halus & Terpusat) --}}
        <div class="mb-8 flex justify-center">
            <a href="{{ route('book.detail', $book->slug) }}" wire:navigate class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#FF500A] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Detail Buku
            </a>
        </div>

        {{-- Kertas Baca Utama --}}
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-10 md:p-16 mb-8 relative">

            {{-- Header Bab --}}
            <header class="text-center mb-12">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-3">
                    {{ $book->title }}
                </h2>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    {{ $chapter->title }}
                </h1>

                <div class="flex items-center justify-center gap-3 text-sm font-semibold text-gray-500">
                    <span class="text-[#FF500A]">Bab {{ $chapter->chapter_number }}</span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1 text-xs text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ number_format($book->views_count ?? 0) }} Pembaca
                    </span>
                </div>

                <hr class="w-12 h-1 bg-gray-200 border-0 rounded mx-auto mt-10">
            </header>

            {{-- Isi Cerita (Font Serif khusus untuk membaca) --}}
            <div class="max-w-none whitespace-pre-line font-serif text-lg md:text-xl text-gray-800 leading-[2.2] tracking-wide">
                {!! nl2br(e($chapter->content)) !!}
            </div>

            {{-- Penutup Cerita & Tombol Apresiasi --}}
            <div class="text-center mt-16 mb-4">
                <span class="text-gray-300 tracking-[0.5em] font-serif text-xl block mb-6">***</span>
                
                <div class="flex flex-col items-center justify-center gap-2">
                    <p class="text-xs font-semibold text-gray-500">Suka dengan bab ini? Berikan apresiasi kepada penulis!</p>
                    <livewire:interactions.book-like-button :book="$book" :key="'like-reader-'.$book->id" />
                </div>
            </div>

        </article>

        {{-- Navigasi Bawah (Bab Berikutnya/Sebelumnya) --}}
        <nav aria-label="Navigasi bab" class="flex flex-col sm:flex-row items-center justify-between gap-4">

            {{-- Tombol Sebelumnya --}}
            @if ($previousChapter)
                <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => $previousChapter->chapter_number]) }}" wire:navigate
                    class="w-full sm:w-1/2 flex items-center justify-center px-6 py-4 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-600 hover:text-[#FF500A] hover:border-orange-200 hover:bg-orange-50 transition-all font-bold text-sm group">
                    <span class="group-hover:-translate-x-1 transition-transform mr-2">&larr;</span> Bab {{ $previousChapter->chapter_number }}
                </a>
            @else
                <div class="w-full sm:w-1/2 flex items-center justify-center px-6 py-4 bg-gray-50 border border-transparent rounded-xl text-gray-400 font-semibold text-sm">
                    Awal Cerita
                </div>
            @endif

            {{-- Tombol Selanjutnya --}}
            @if ($nextChapter)
                <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => $nextChapter->chapter_number]) }}" wire:navigate
                    class="w-full sm:w-1/2 flex items-center justify-center px-6 py-4 bg-[#FF500A] rounded-xl shadow-sm shadow-orange-200 text-white hover:bg-[#e04508] transition-all font-bold text-sm group">
                    Lanjut ke Bab {{ $nextChapter->chapter_number }} <span class="group-hover:translate-x-1 transition-transform ml-2">&rarr;</span>
                </a>
            @else
                <div class="w-full sm:w-1/2 flex items-center justify-center px-6 py-4 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 font-bold text-sm">
                    Tamat
                </div>
            @endif

        </nav>

        {{-- Bagian Komentar & Diskusi Pembaca --}}
        <livewire:interactions.book-comments :book="$book" :key="'comments-reader-'.$book->id" />

    </div>
</div>
