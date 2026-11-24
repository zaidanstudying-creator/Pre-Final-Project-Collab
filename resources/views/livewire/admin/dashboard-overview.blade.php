<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-[#F5F6FA] min-h-screen">

    {{-- Header Admin Dashboard --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-8 mb-8 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-gray-900 rounded-full">Dashboard Admin</span>
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-[#FF500A] bg-orange-100 rounded-full">Ringkasan Platform</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Statistik & Moderasi Komentar</h1>
            <p class="text-sm font-semibold text-gray-500 mt-2">Pantau metrik utama Weboo dan pantau aktivitas komentar komunitas secara langsung.</p>
        </div>

        {{-- Tombol Pintasan Cepat --}}
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.moderation.index') }}" wire:navigate class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-full text-sm transition-all shadow-sm border border-gray-200">
                <svg class="w-4 h-4 mr-2 text-[#FF500A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Moderasi Naskah
            </a>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- 4 Kartu Metrik Platform --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
        {{-- Kartu 1: Total Pengguna --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Pengguna</p>
                <h3 class="text-3xl font-black text-gray-900 leading-tight">{{ number_format($metrics['total_users'] ?? 0) }}</h3>
                <span class="text-[11px] font-semibold text-gray-400">Akun terdaftar</span>
            </div>
        </div>

        {{-- Kartu 2: Buku Terbit --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Buku Terbit</p>
                <h3 class="text-3xl font-black text-emerald-600 leading-tight">{{ number_format($metrics['total_published_books'] ?? 0) }}</h3>
                <span class="text-[11px] font-semibold text-gray-400">Status dipublikasikan</span>
            </div>
        </div>

        {{-- Kartu 3: Antrean Moderasi --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Antrean Moderasi</p>
                <h3 class="text-3xl font-black {{ ($metrics['total_pending_books'] ?? 0) > 0 ? 'text-[#FF500A]' : 'text-gray-900' }} leading-tight">
                    {{ number_format($metrics['total_pending_books'] ?? 0) }}
                </h3>
                <span class="text-[11px] font-semibold text-gray-400">Menunggu tinjauan</span>
            </div>
        </div>

        {{-- Kartu 4: Total Komentar --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-[#FF500A] flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Komentar</p>
                <h3 class="text-3xl font-black text-gray-900 leading-tight">{{ number_format($metrics['total_comments'] ?? 0) }}</h3>
                <span class="text-[11px] font-semibold text-gray-400">Diskusi pembaca</span>
            </div>
        </div>
    </div>

    {{-- Tabel Moderasi Komentar Terbaru --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        
        {{-- Header Tabel & Kolom Pencarian --}}
        <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Moderasi Komentar Terbaru</h2>
                <p class="text-xs font-medium text-gray-500 mt-1">Periksa komentar yang dikirim oleh pembaca dan bersihkan komentar spam atau melanggar aturan.</p>
            </div>

            <div class="w-full md:w-80">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Cari pengirim, cerita, komentar..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-full focus:bg-white focus:border-[#FF500A] focus:ring-1 focus:ring-[#FF500A] transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Data Komentar --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-[11px] font-extrabold uppercase tracking-wider text-gray-400 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Pengirim</th>
                        <th scope="col" class="px-6 py-4">Judul Cerita</th>
                        <th scope="col" class="px-6 py-4">Isi Komentar</th>
                        <th scope="col" class="px-6 py-4">Waktu</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($comments as $comment)
                        <tr wire:key="admin-comment-{{ $comment->id }}" class="hover:bg-gray-50/80 transition-colors">
                            {{-- Pengirim --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 shrink-0 border border-gray-200">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'User') }}&background=2A2B2E&color=fff"
                                             alt="{{ $comment->user->name ?? 'User' }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $comment->user->name ?? 'User Dihapus' }}</div>
                                        <div class="text-xs text-gray-400">{{ $comment->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Judul Cerita --}}
                            <td class="px-6 py-4">
                                @if ($comment->book)
                                    <a href="{{ route('book.detail', $comment->book->slug ?? $comment->book->id) }}"
                                       target="_blank"
                                       class="font-semibold text-gray-900 hover:text-[#FF500A] transition-colors line-clamp-1 max-w-[200px]"
                                       title="{{ $comment->book->title }}">
                                        {{ $comment->book->title }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 italic">Buku telah dihapus</span>
                                @endif
                            </td>

                            {{-- Isi Komentar --}}
                            <td class="px-6 py-4">
                                <p class="text-gray-700 text-sm line-clamp-2 max-w-md leading-relaxed" title="{{ $comment->body }}">
                                    {{ $comment->body }}
                                </p>
                            </td>

                            {{-- Waktu Kirim --}}
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                <div>{{ $comment->created_at->diffForHumans() }}</div>
                                <div class="text-[10px] text-gray-400">{{ $comment->created_at->format('d M Y H:i') }}</div>
                            </td>

                            {{-- Tombol Aksi Hapus --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button type="button"
                                        wire:click="deleteComment({{ $comment->id }})"
                                        wire:confirm="Yakin ingin menghapus komentar ini dari platform?"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 hover:text-rose-700 transition-colors shadow-xs">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-30 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <p class="text-base font-bold text-gray-700">Tidak ada komentar ditemukan</p>
                                <p class="text-xs text-gray-400 mt-1">Coba gunakan kata kunci pencarian yang berbeda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($comments->hasPages())
            <div class="p-6 border-t border-gray-100 flex justify-center">
                {{ $comments->links() }}
            </div>
        @endif

    </div>

</div>
