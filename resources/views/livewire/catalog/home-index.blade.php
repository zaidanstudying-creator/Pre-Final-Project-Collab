<div class="min-h-screen bg-stone-50 text-stone-900">
    <section class="overflow-hidden bg-gradient-to-br from-rose-50 via-orange-50 to-amber-100">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-rose-700">Temukan cerita berikutnya</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-bold tracking-tight sm:text-6xl">Ruang kecil untuk cerita yang besar.</h1>
            <p class="mt-5 max-w-xl text-lg leading-relaxed text-stone-600">Jelajahi kisah pilihan, temukan penulis baru, dan mulai membaca kapan saja.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-12 sm:px-8" aria-labelledby="catalog-title">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-rose-700">Katalog pembaca</p>
                <h2 id="catalog-title" class="mt-1 text-3xl font-bold tracking-tight">Cerita untukmu</h2>
            </div>
            <div class="grid gap-3 sm:grid-cols-[minmax(16rem,24rem)_14rem]">
                <label class="sr-only" for="book-search">Cari judul buku</label>
                <input id="book-search" type="search" wire:model.live.debounce.300ms="search" placeholder="Cari judul buku..." class="w-full rounded-xl border-stone-200 bg-white px-4 py-3 shadow-sm placeholder:text-stone-400 focus:border-rose-400 focus:ring-rose-400">
                <label class="sr-only" for="category-filter">Filter kategori</label>
                <select id="category-filter" wire:model.live="category" class="rounded-xl border-stone-200 bg-white px-4 py-3 shadow-sm focus:border-rose-400 focus:ring-rose-400">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div wire:loading class="mt-5 text-sm text-stone-500">Memuat cerita...</div>
        @if ($books->isEmpty())
            <div class="mt-10 rounded-2xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center">
                <p class="text-lg font-semibold">Belum ada cerita yang cocok</p>
                <p class="mt-2 text-stone-500">Coba kata kunci atau kategori lainnya.</p>
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($books as $book)
                    <a href="{{ route('book.detail', $book->slug) }}" wire:navigate class="group overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-rose-400">
                        <div class="aspect-[4/5] overflow-hidden bg-stone-100">
                            @if ($book->cover_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul {{ $book->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-rose-100 to-amber-100 p-8 text-center text-2xl font-bold text-rose-900">{{ $book->title }}</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">{{ $book->category?->name ?? 'Tanpa kategori' }}</span>
                            <h3 class="mt-3 line-clamp-2 text-lg font-bold leading-snug group-hover:text-rose-700">{{ $book->title }}</h3>
                            <p class="mt-2 text-sm text-stone-500">oleh {{ $book->user?->name ?? 'Penulis' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">{{ $books->links() }}</div>
        @endif
    </section>
</div>
