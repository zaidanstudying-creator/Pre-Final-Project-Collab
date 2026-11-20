<div class="bg-white min-h-screen">

    {{-- Header Profil (Dark Background ala Wattpad) --}}
    <div class="bg-[#2A2B2E] pt-12 pb-8 px-4 sm:px-6 lg:px-8 text-center border-b-4 border-[#FF500A]">
        <div class="max-w-3xl mx-auto flex flex-col items-center">

            {{-- Foto Profil --}}
            <div class="w-24 h-24 md:w-28 md:h-28 rounded-full overflow-hidden border-2 border-white/20 mb-4 bg-gray-800">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=FF500A&color=fff&size=200" class="w-full h-full object-cover">
            </div>

            {{-- Nama & Username --}}
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">{{ $user->name }}</h1>
            <p class="text-sm text-gray-400 mb-6">{{ '@' . strtolower(str_replace(' ', '', $user->name)) }}</p>

            {{-- Statistik (Tanpa Follower/Koin) --}}
            <div class="flex items-center justify-center gap-10 text-white">
                <div class="text-center">
                    <p class="text-xl font-bold">{{ $publishedBooks->count() }}</p>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Karya Terbit</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold">{{ $publishedBooks->sum(fn($b) => $b->chapters->count()) }}</p>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Total Bab</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Konten Utama: Daftar Karya --}}
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Tab Karya --}}
        <div class="border-b border-gray-200 mb-8">
            <h2 class="inline-block pb-3 text-sm font-bold text-gray-900 border-b-2 border-gray-900 uppercase tracking-wider">
                Karya oleh {{ explode(' ', trim($user->name))[0] }}
            </h2>
        </div>

        {{-- Grid Buku --}}
        @if ($publishedBooks->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <div class="text-4xl mb-3">📚</div>
                <p class="text-sm font-bold text-gray-900">Belum Ada Karya</p>
                <p class="text-sm text-gray-500 mt-1">Penulis ini belum menerbitkan cerita apa pun.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                @foreach ($publishedBooks as $book)
                    <a href="{{ route('book.detail', $book->slug ?? $book->id) }}" wire:navigate class="group block">
                        {{-- Thumbnail Buku (Rasio 2:3 ala Wattpad) --}}
                        <div class="aspect-[2/3] bg-gray-100 rounded-lg overflow-hidden mb-3 shadow-sm border border-gray-150 relative">
                            @if ($book->cover_image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                                    <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    <span class="text-[10px] font-bold uppercase">Tanpa Cover</span>
                                </div>
                            @endif
                        </div>

                        {{-- Judul Buku --}}
                        <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-[#FF500A] transition-colors">{{ $book->title }}</h3>
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-widest mt-1">{{ $book->category->name ?? 'Umum' }}</p>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
