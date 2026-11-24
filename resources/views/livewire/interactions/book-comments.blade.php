<div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">

    {{-- Header Bagian Komentar --}}
    <div class="flex items-center justify-between pb-6 mb-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Komentar & Diskusi</h3>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-orange-100 text-[#FF500A]">
                {{ $totalComments }}
            </span>
        </div>
    </div>

    {{-- Pesan Flash Status --}}
    @if (session('comment_status'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('comment_status') }}
            </span>
        </div>
    @endif

    {{-- Form Tulis Komentar --}}
    @auth
        <form wire:submit="postComment" class="mb-8">
            <div class="flex items-start gap-3 sm:gap-4">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 shrink-0 border border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FF500A&color=fff"
                         alt="{{ auth()->user()->name }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="flex-1">
                    <textarea wire:model="body"
                              rows="3"
                              maxlength="500"
                              placeholder="Tulis tanggapan atau kesanmu tentang cerita ini..."
                              class="w-full rounded-xl border-gray-300 bg-gray-50/50 p-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-[#FF500A] focus:ring-1 focus:ring-[#FF500A] transition-all resize-none shadow-sm"></textarea>

                    @error('body')
                        <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-400 font-medium">Maksimal 500 karakter</span>
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="px-6 py-2.5 bg-[#FF500A] hover:bg-[#e04508] text-white text-sm font-bold rounded-full transition-all shadow-sm shadow-orange-200 flex items-center gap-2">
                            <span wire:loading.remove wire:target="postComment">Kirim Komentar</span>
                            <span wire:loading wire:target="postComment">Mengirim...</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200 text-center">
            <p class="text-sm font-medium text-gray-600 mb-3">
                Tertarik ikut berdiskusi atau memberikan tanggapan untuk cerita ini?
            </p>
            <a href="{{ route('login') }}"
               wire:navigate
               class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-full transition-colors shadow-sm">
                Masuk untuk Berkomentar
            </a>
        </div>
    @endauth

    {{-- Daftar Komentar --}}
    <div class="space-y-4">
        @forelse ($comments as $comment)
            <div wire:key="comment-{{ $comment->id }}" class="p-4 sm:p-5 rounded-xl bg-gray-50/60 border border-gray-100 flex items-start gap-4 transition-colors hover:bg-gray-50">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 shrink-0 border border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'User') }}&background=2A2B2E&color=fff"
                         alt="{{ $comment->user->name ?? 'User' }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-sm font-bold text-gray-900">{{ $comment->user->name ?? 'Anonim' }}</span>
                            @if ($comment->user_id === $book->user_id)
                                <span class="px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider bg-orange-100 text-[#FF500A] rounded-full">
                                    Penulis
                                </span>
                            @elseif ($comment->user?->isAdmin())
                                <span class="px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider bg-gray-900 text-white rounded-full">
                                    Admin
                                </span>
                            @endif
                            <span class="text-xs text-gray-400">&bull; {{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- Tombol Hapus (Hanya untuk pemilik komentar atau admin) --}}
                        @auth
                            @if (auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                <button type="button"
                                        wire:click="deleteComment({{ $comment->id }})"
                                        wire:confirm="Yakin ingin menghapus komentar ini?"
                                        class="text-xs font-semibold text-rose-500 hover:text-rose-700 hover:underline flex items-center gap-1 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            @endif
                        @endauth
                    </div>

                    <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $comment->body }}
                    </p>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-3 opacity-40 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p class="text-sm font-semibold text-gray-500">Belum ada komentar untuk cerita ini.</p>
                <p class="text-xs text-gray-400 mt-1">Jadilah yang pertama membagikan kesan atau diskusi!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination Komentar --}}
    @if ($comments->hasPages())
        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-center">
            {{ $comments->links() }}
        </div>
    @endif

</div>
