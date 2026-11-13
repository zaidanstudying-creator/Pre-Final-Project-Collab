<div class="min-h-screen bg-[#f8f6f1] px-5 py-8 text-stone-800 sm:px-8 sm:py-12">
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('book.detail', $book->slug) }}" wire:navigate class="text-sm font-sans font-semibold text-rose-700 hover:text-rose-900">← {{ $book->title }}</a>
        <header class="mt-10 border-b border-stone-300/80 pb-8 text-center">
            <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">{{ $book->title }}</p>
            <p class="mt-5 font-sans text-sm font-medium text-rose-700">Bab {{ $chapter->chapter_number }}</p>
            <h1 class="mt-2 font-serif text-3xl font-bold leading-tight text-stone-900 sm:text-4xl">{{ $chapter->title }}</h1>
        </header>
        <article class="mx-auto mt-10 max-w-none whitespace-pre-line font-serif text-lg leading-8 sm:text-xl sm:leading-9">
            {!! nl2br(e($chapter->content)) !!}
        </article>
        <nav aria-label="Navigasi bab" class="mt-14 flex items-center justify-between gap-4 border-t border-stone-300/80 pt-6 font-sans">
            @if ($previousChapter)
                <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => $previousChapter->chapter_number]) }}" wire:navigate class="rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm font-semibold transition hover:border-rose-300 hover:text-rose-800">← Bab Sebelumnya</a>
            @else
                <span class="rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-400">← Bab Sebelumnya</span>
            @endif
            @if ($nextChapter)
                <a href="{{ route('book.read', ['book_slug' => $book->slug, 'chapter_number' => $nextChapter->chapter_number]) }}" wire:navigate class="rounded-xl bg-rose-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-800">Bab Selanjutnya →</a>
            @else
                <span class="rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-400">Bab Selanjutnya →</span>
            @endif
        </nav>
    </div>
</div>
