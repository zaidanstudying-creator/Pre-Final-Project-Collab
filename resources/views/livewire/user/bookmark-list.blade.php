<div class="min-h-screen bg-slate-50 px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Rak bacaan</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Bookmark saya</h1>
                <p class="mt-2 text-slate-600">Buku yang kamu simpan untuk dibaca nanti.</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full bg-indigo-100 px-4 py-2 text-sm font-semibold text-indigo-800">{{ $books->count() }} buku</span>
        </div>

        @if (session('success'))
            <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        @if ($books->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-2xl text-indigo-600">♡</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">Rakmu masih kosong</h2>
                <p class="mt-2 text-sm text-slate-500">Simpan buku yang menarik dan buku itu akan muncul di sini.</p>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($books as $book)
                    <article wire:key="bookmark-{{ $book->id }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            @if ($book->cover_image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center text-sm font-medium text-slate-400">Sampul belum tersedia</div>
                            @endif
                            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm">{{ $book->category?->name ?? 'Tanpa kategori' }}</span>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <h2 class="line-clamp-2 text-lg font-bold leading-snug text-slate-900">{{ $book->title }}</h2>
                            <p class="mt-2 text-sm text-slate-500">oleh <span class="font-medium text-slate-700">{{ $book->user?->name ?? 'Penulis tidak diketahui' }}</span></p>
                            @if ($book->synopsis)
                                <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ $book->synopsis }}</p>
                            @endif
                            <div class="mt-auto border-t border-slate-100 pt-4">
                                <button type="button" wire:click="remove({{ $book->id }})" wire:confirm="Hapus {{ $book->title }} dari bookmark?" wire:loading.attr="disabled" class="w-full rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 disabled:opacity-50">Hapus dari bookmark</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
