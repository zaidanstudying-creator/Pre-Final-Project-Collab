<div class="min-h-screen bg-stone-50 px-5 py-10 text-stone-900 sm:px-8 sm:py-16">
    <div class="mx-auto max-w-6xl">
        <a href="{{ route('home') }}" wire:navigate class="text-sm font-semibold text-rose-700 hover:text-rose-900">← Kembali ke katalog</a>
        <div class="mt-8 grid gap-10 lg:grid-cols-[18rem_1fr] lg:gap-14">
            <div class="mx-auto w-full max-w-sm overflow-hidden rounded-3xl bg-white shadow-xl shadow-stone-200/70">
                @if ($book->cover_image)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul {{ $book->title }}" class="aspect-[4/5] w-full object-cover">
                @else
                    <div class="flex aspect-[4/5] items-center justify-center bg-gradient-to-br from-rose-100 to-amber-100 p-8 text-center text-3xl font-bold text-rose-900">{{ $book->title }}</div>
                @endif
            </div>
            <div class="py-2">
                <span class="rounded-full bg-rose-100 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-rose-800">{{ $book->category?->name ?? 'Tanpa kategori' }}</span>
                <h1 class="mt-5 text-4xl font-bold tracking-tight sm:text-5xl">{{ $book->title }}</h1>
                <p class="mt-3 text-lg text-stone-600">Karya <span class="font-semibold text-stone-800">{{ $book->user?->name ?? 'Penulis' }}</span></p>
                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <button type="button" wire:click="saveToShelf" wire:loading.attr="disabled" class="rounded-xl bg-rose-700 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-rose-800 disabled:opacity-60">Simpan ke Rak</button>
                    @if (session('status')) <span role="status" class="text-sm font-medium text-emerald-700">{{ session('status') }}</span> @endif
                </div>
                <section class="mt-10 border-t border-stone-200 pt-8">
                    <h2 class="text-xl font-bold">Tentang cerita ini</h2>
                    <p class="mt-4 whitespace-pre-line text-base leading-8 text-stone-600">{{ $book->synopsis }}</p>
                </section>
            </div>
        </div>

        <section class="mt-16 border-t border-stone-200 pt-10">
            <div class="flex items-end justify-between"><div><p class="text-sm font-medium text-rose-700">Mulai membaca</p><h2 class="mt-1 text-3xl font-bold">Daftar bab</h2></div><span class="text-sm text-stone-500">{{ $book->chapters->count() }} bab</span></div>
            <div class="mt-6 divide-y divide-stone-200 overflow-hidden rounded-2xl border border-stone-200 bg-white">
                @forelse ($book->chapters as $chapter)
                    <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => $chapter->chapter_number]) }}" wire:navigate class="flex items-center justify-between gap-4 px-5 py-4 transition hover:bg-rose-50 sm:px-6">
                        <div><p class="text-xs font-semibold uppercase tracking-wider text-rose-700">Bab {{ $chapter->chapter_number }}</p><h3 class="mt-1 font-semibold">{{ $chapter->title }}</h3></div><span class="text-xl text-stone-400" aria-hidden="true">→</span>
                    </a>
                @empty
                    <p class="px-6 py-10 text-center text-stone-500">Bab untuk cerita ini belum tersedia.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
