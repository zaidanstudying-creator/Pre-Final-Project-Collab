<div class="bg-white min-h-screen pb-16">

    {{-- Hero Banner --}}
    <div class="bg-[#2A2B2E] w-full pt-16 pb-20 px-4 text-center border-b-[6px] border-[#FF500A]">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-4 leading-tight">
                Datang karena cerita. <br>
                <span class="text-[#FF500A]">Bertahan karena koneksi.</span>
            </h1>
            <p class="text-base md:text-lg text-gray-300 font-medium max-w-2xl mx-auto mb-8">
                Temukan ribuan karya fiksi dan non-fiksi dari penulis berbakat Weboo. Baca, tulis, dan bagikan imajinasimu.
            </p>

            @guest
                <a href="{{ route('register') }}" class="inline-block bg-white text-gray-900 font-bold px-8 py-3.5 rounded-full hover:bg-gray-100 transition-colors">
                    Mulai Membaca Sekarang
                </a>
                <p class="text-sm text-gray-400 mt-4">
                    Sudah memiliki akun? <a href="{{ route('login') }}" class="text-white font-bold hover:underline">Masuk</a>
                </p>
            @endguest
        </div>
    </div>

    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 mt-12">

        {{-- Header & Filter --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Cerita pilihan untuk kamu</h2>
                <p class="text-sm text-gray-500 mt-1">Berdasarkan karya terbaru yang baru saja diterbitkan.</p>
            </div>

            <div class="relative inline-block w-40 sm:w-48">
                {{-- PERBAIKAN 1: Nama wire:model disamakan persis dengan PHP ($category) --}}
                <select wire:model.live="category"
                    class="block w-full appearance-none bg-white border border-[#FF500A] text-gray-700 py-2 pl-4 pr-10 rounded-full text-sm font-bold shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] transition-colors cursor-pointer hover:bg-orange-50">
                    <option value="">Semua Kategori</option>

                    {{-- PERBAIKAN 2: Memakai variabel $categories dari PHP, dan di-loop sebagai $cat agar tidak bentrok --}}
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                {{-- Ikon panah kustom agar tidak menabrak teks --}}
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#FF500A]">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Grid Daftar Buku (Gaya Wattpad) --}}
        @if ($books->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <div class="text-4xl mb-3">🔍</div>
                <h3 class="text-lg font-bold text-gray-900">Tidak ada cerita ditemukan</h3>
                <p class="text-sm text-gray-500 mt-1">Coba cari dengan kata kunci atau genre yang berbeda.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-4 gap-y-10">
                @foreach ($books as $book)
                    <a href="{{ route('book.detail', $book->slug ?? $book->id) }}" class="group flex flex-col">

                        {{-- Cover Buku --}}
                        <div class="relative aspect-[2/3] w-full bg-gray-100 rounded-lg overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.08)] mb-3 group-hover:shadow-[0_8px_16px_rgba(0,0,0,0.12)] transition-all duration-300">
                            @if ($book->cover_image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-gray-50">
                                    <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                            @endif

                            {{-- Overlay Hover "Mulai Membaca" --}}
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[1px]">
                                <span class="bg-[#FF500A] text-white text-xs font-bold px-4 py-2 rounded-full">
                                    Baca
                                </span>
                            </div>
                        </div>

                        {{-- Info Buku --}}
                        <div class="px-1">
                            <h3 class="font-bold text-sm text-gray-900 leading-snug line-clamp-2 mb-1 group-hover:text-[#FF500A] transition-colors" title="{{ $book->title }}">
                                {{ $book->title }}
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                                oleh <span class="font-semibold text-gray-700">{{ $book->user->name }}</span>
                            </p>

                            {{-- Meta (Kategori & Jumlah Bab) --}}
                            <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    {{ $book->category->name }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    {{ $book->chapters_count ?? $book->chapters()->count() }} Bab
                                </span>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{ $books->links() }}
            </div>
        @endif

    </div>
</div>
