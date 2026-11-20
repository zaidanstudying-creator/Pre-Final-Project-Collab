<div class="bg-[#F5F6FA] min-h-screen pb-20">

    {{-- Header Background (Berwarna Abu-abu gelap) --}}
    <div class="bg-[#2A2B2E] pt-8 pb-32 border-b-4 border-[#FF500A]">
        <div class="max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center text-sm font-semibold text-gray-300 hover:text-white transition-colors mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    {{-- Konten Utama (Naik ke atas menimpa header) --}}
    <div class="max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8 -mt-24">

        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 flex flex-col md:flex-row overflow-hidden border border-gray-100">

            {{-- Sisi Kiri: Cover Buku --}}
            <div class="w-full md:w-[320px] shrink-0 bg-gray-50 relative p-6 flex flex-col items-center justify-start border-r border-gray-100">
                <div class="w-48 md:w-56 aspect-[2/3] rounded-lg shadow-lg overflow-hidden border border-gray-200 relative mb-6">
                    @if ($book->cover_image)
                        <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul {{ $book->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400">
                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest">No Cover</span>
                        </div>
                    @endif
                </div>

                {{-- Meta Info Cepat --}}
                <div class="w-full flex justify-center gap-6 text-center border-t border-gray-200 pt-4">
                    <div>
                        <p class="text-lg font-black text-gray-900 leading-none">{{ $book->chapters->count() }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Bab</p>
                    </div>
                    <div>
                        <p class="text-lg font-black text-gray-900 leading-none">{{ $book->category?->name ?? '-' }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Genre</p>
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Detail & Sinopsis --}}
            <div class="flex-1 p-6 md:p-10 flex flex-col">

                {{-- Judul & Penulis --}}
                <div class="mb-6">
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight text-gray-900 leading-tight mb-2">
                        {{ $book->title }}
                    </h1>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full overflow-hidden bg-gray-200 border border-gray-300">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($book->user?->name ?? 'User') }}&background=FF500A&color=fff" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm font-semibold text-gray-600">
                            oleh <a href="{{ route('profile', $book->user?->id) }}" class="text-gray-900 hover:text-[#FF500A] transition-colors underline decoration-2 underline-offset-2">{{ $book->user?->name ?? 'Penulis Anonim' }}</a>
                        </p>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-wrap items-center gap-3 mb-8 pb-8 border-b border-gray-100">
                    {{-- Tombol Mulai Membaca (Otomatis ke Bab 1) --}}
                    @if($book->chapters->count() > 0)
                        <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => 1]) }}" wire:navigate class="px-8 py-3 bg-[#FF500A] hover:bg-[#e04508] text-white text-sm font-bold rounded-full transition-colors shadow-sm shadow-orange-200 flex items-center gap-2">
                            Mulai Membaca
                        </a>
                    @else
                        <button disabled class="px-8 py-3 bg-gray-200 text-gray-500 text-sm font-bold rounded-full cursor-not-allowed">
                            Belum Ada Bab
                        </button>
                    @endif

                    {{-- Tombol Simpan ke Rak --}}
                    <button type="button" wire:click="saveToShelf" wire:loading.attr="disabled" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-[#FF500A] hover:border-[#FF500A] text-sm font-bold rounded-full transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        <span wire:loading.remove wire:target="saveToShelf">Simpan</span>
                        <span wire:loading wire:target="saveToShelf">Menyimpan...</span>
                    </button>

                    @if (session('status'))
                        <span class="text-xs font-bold text-emerald-600 ml-2 animate-pulse">
                            ✅ Tersimpan!
                        </span>
                    @endif
                </div>

                {{-- Sinopsis --}}
                <div class="flex-1">
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-3">Sinopsis</h3>
                    <p class="whitespace-pre-line text-sm leading-relaxed text-gray-700">
                        {{ $book->synopsis ?: 'Penulis belum menambahkan sinopsis untuk cerita ini.' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Daftar Bab --}}
        <div class="mt-12">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                Daftar Isi <span class="bg-gray-200 text-gray-700 text-xs py-1 px-2 rounded-full">{{ $book->chapters->count() }}</span>
            </h3>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                @forelse ($book->chapters as $chapter)
                    <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => $chapter->chapter_number]) }}" wire:navigate
                        class="flex items-center justify-between p-4 sm:px-6 sm:py-5 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors group">

                        <div class="flex items-center gap-4">
                            <span class="text-sm font-bold text-gray-400 group-hover:text-[#FF500A] transition-colors w-8">
                                {{ str_pad($chapter->chapter_number, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-sm font-bold text-gray-800 group-hover:text-gray-900">
                                {{ $chapter->title }}
                            </span>
                        </div>

                        <span class="text-gray-300 group-hover:text-[#FF500A] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </a>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-sm font-semibold text-gray-500">Penulis belum menerbitkan bab apa pun untuk cerita ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
