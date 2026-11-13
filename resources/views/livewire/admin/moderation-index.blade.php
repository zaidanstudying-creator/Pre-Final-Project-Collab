<div class="min-h-screen bg-slate-50 px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Administrasi</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Moderasi buku</h1>
                <p class="mt-2 text-slate-600">Tinjau kiriman penulis sebelum buku diterbitkan.</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800">
                {{ $books->count() }} menunggu ditinjau
            </span>
        </div>

        @if (session('success'))
            <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        @if ($books->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-2xl text-indigo-600">✓</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">Semua sudah ditinjau</h2>
                <p class="mt-2 text-sm text-slate-500">Belum ada buku yang menunggu moderasi.</p>
            </div>
        @else
            <div class="space-y-5">
                @foreach ($books as $book)
                    <article wire:key="book-{{ $book->id }}" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-[160px_1fr]">
                            <div class="aspect-[3/4] overflow-hidden rounded-xl bg-slate-100">
                                @if ($book->cover_image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center p-4 text-center text-sm font-medium text-slate-400">Sampul belum tersedia</div>
                                @endif
                            </div>
                            <div class="flex min-w-0 flex-col">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Menunggu moderasi</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $book->category?->name ?? 'Tanpa kategori' }}</span>
                                </div>
                                <h2 class="mt-4 text-2xl font-bold text-slate-900">{{ $book->title }}</h2>
                                <p class="mt-1 text-sm text-slate-500">Oleh {{ $book->user?->name ?? 'Penulis tidak diketahui' }} · {{ $book->chapters->count() }} bab</p>
                                <p class="mt-4 line-clamp-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $book->synopsis }}</p>
                                @if ($book->admin_notes)
                                    <p class="mt-4 rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-600"><span class="font-semibold text-slate-800">Catatan sebelumnya:</span> {{ $book->admin_notes }}</p>
                                @endif
                                @if ($book->chapters->isNotEmpty())
                                    <div class="mt-5 border-t border-slate-100 pt-4">
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Daftar bab</h3>
                                        <ul class="mt-2 grid gap-1 text-sm text-slate-600 sm:grid-cols-2">
                                            @foreach ($book->chapters->take(6) as $chapter)
                                                <li class="truncate">{{ $chapter->chapter_number }}. {{ $chapter->title }}</li>
                                            @endforeach
                                        </ul>
                                        @if ($book->chapters->count() > 6)
                                            <p class="mt-2 text-xs text-slate-400">dan {{ $book->chapters->count() - 6 }} bab lainnya</p>
                                        @endif
                                    </div>
                                @endif
                                <div class="mt-6 flex flex-wrap gap-3">
                                    <button type="button" wire:click="approve({{ $book->id }})" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:opacity-50">Setujui &amp; Terbitkan</button>
                                    <button type="button" wire:click="startReject({{ $book->id }})" class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Tolak / Minta Revisi</button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        @if ($rejectingBookId)
            <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/50 p-4" role="dialog" aria-modal="true" aria-labelledby="reject-title" wire:key="reject-modal-{{ $rejectingBookId }}">
                <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl sm:p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 id="reject-title" class="text-xl font-bold text-slate-900">Tolak atau minta revisi</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Tuliskan alasan yang jelas agar penulis tahu bagian yang perlu diperbaiki.</p>
                        </div>
                        <button type="button" wire:click="closeRejectForm" aria-label="Tutup" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700">✕</button>
                    </div>
                    <form wire:submit="reject" class="mt-6">
                        <label for="adminNotes" class="mb-2 block text-sm font-semibold text-slate-700">Catatan admin</label>
                        <textarea id="adminNotes" wire:model="adminNotes" rows="5" minlength="10" required placeholder="Jelaskan alasan penolakan atau revisi (minimal 10 karakter)..." class="w-full rounded-xl border-slate-300 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('adminNotes') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeRejectForm" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                            <button type="submit" wire:loading.attr="disabled" class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-700 disabled:opacity-50">Kirim catatan &amp; tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
