<div class="bg-[#F5F6FA] min-h-screen pb-16 pt-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header "Cerita Saya" --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Cerita Saya</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola draf, perbarui bab, dan pantau status karyamu di sini.</p>
            </div>

            <a href="{{ route('author.books.create') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-2.5 bg-[#FF500A] text-white text-sm font-bold rounded-full hover:bg-[#e04508] transition-colors shadow-sm">
                + Tulis Cerita Baru
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-bold flex items-center gap-3">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-bold flex items-center gap-3">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- Tab Status (Opsional, untuk visual penyaring) --}}
        <div class="bg-white border-b border-gray-200 mb-6 rounded-t-xl px-2 pt-2">
            <nav class="-mb-px flex space-x-6 overflow-x-auto">
                <a href="#" class="border-[#FF500A] text-[#FF500A] whitespace-nowrap py-3 px-2 border-b-2 font-bold text-sm">
                    Semua Karya ({{ $books->count() }})
                </a>
                <span class="border-transparent text-gray-500 whitespace-nowrap py-3 px-2 border-b-2 font-medium text-sm">
                    Diterbitkan ({{ $books->where('status', 'published')->count() }})
                </span>
                <span class="border-transparent text-gray-500 whitespace-nowrap py-3 px-2 border-b-2 font-medium text-sm">
                    Draf/Revisi ({{ $books->whereIn('status', ['draft', 'rejected'])->count() }})
                </span>
            </nav>
        </div>

        {{-- Daftar Karya --}}
        <div class="bg-white rounded-b-xl rounded-tr-xl shadow-sm border border-gray-150 p-4 sm:p-6 mb-8">
            @if ($books->isEmpty())
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Cerita</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-6 max-w-sm mx-auto">Mulai tuangkan imajinasimu ke dalam kata-kata. Buat cerita pertamamu sekarang.</p>
                    <a href="{{ route('author.books.create') }}" wire:navigate class="inline-flex items-center px-5 py-2 border border-gray-300 shadow-sm text-sm font-bold rounded-full text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Mulai Menulis
                    </a>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($books as $book)
                        @php
                            // Pewarnaan Label Status
                            $statusColor = match($book->status) {
                                'published' => 'bg-emerald-100 text-emerald-700',
                                'pending' => 'bg-amber-100 text-amber-700',
                                'rejected' => 'bg-rose-100 text-rose-700',
                                default => 'bg-gray-100 text-gray-700'
                            };

                            $statusText = match($book->status) {
                                'published' => 'Terbit',
                                'pending' => 'Sedang Direview',
                                'rejected' => 'Butuh Revisi',
                                default => 'Draf'
                            };
                        @endphp

                        <div class="py-5 flex flex-col sm:flex-row gap-5 group">

                            {{-- Thumbnail Kiri --}}
                            <div class="shrink-0 w-24 sm:w-28 aspect-[2/3] bg-gray-100 rounded-md overflow-hidden shadow-sm relative">
                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                {{-- Label Status Overlay --}}
                                <div class="absolute bottom-0 inset-x-0 bg-white/90 backdrop-blur text-[9px] font-black uppercase tracking-wider text-center py-1 border-t border-gray-100">
                                    {{ $statusText }}
                                </div>
                            </div>

                            {{-- Info Cerita & Aksi --}}
                            <div class="flex-1 min-w-0 flex flex-col">
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-1 truncate">{{ $book->title }}</h3>
                                        <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">
                                            <span>{{ $book->category->name }}</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span>{{ $book->chapters->count() }} Bab</span>
                                        </div>
                                    </div>

                                    {{-- Tombol Edit Cepat (Desktop) --}}
                                    <div class="hidden sm:flex gap-2">
                                        <a href="{{ route('author.books.edit', $book) }}" class="text-gray-400 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 p-2 rounded-lg transition-colors" title="Edit Info Buku">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    </div>
                                </div>

                                <p class="text-sm text-gray-600 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $book->synopsis ?: 'Belum ada sinopsis. Tambahkan sinopsis agar pembaca tahu tentang apa ceritamu.' }}
                                </p>

                                {{-- Peringatan Penolakan --}}
                                @if($book->status === 'rejected' && $book->admin_notes)
                                    <div class="mt-auto mb-4 bg-rose-50 border border-rose-100 p-3 rounded-lg text-sm text-rose-700">
                                        <span class="font-bold">Catatan Editor:</span> {{ $book->admin_notes }}
                                    </div>
                                @endif

                                {{-- Aksi Utama --}}
                                <div class="mt-auto pt-2 flex flex-wrap items-center gap-3">
                                    <a href="{{ route('author.chapters.index', $book) }}" wire:navigate class="inline-flex items-center justify-center px-5 py-2 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-800 transition-colors shadow-sm">
                                        Lanjutkan Menulis
                                    </a>

                                    {{-- Tombol Ajukan Publikasi (Muncul jika status Draf atau Ditolak/Revisi) --}}
                                    @if(in_array($book->status, ['draft', 'rejected']))
                                        <button type="button" wire:click="submitForReview({{ $book->id }})" wire:confirm="Kirim naskah ini ke Admin untuk ditinjau dan diterbitkan?" class="inline-flex items-center justify-center px-5 py-2 bg-[#FF500A] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#e04508] transition-colors shadow-sm">
                                            Ajukan Publikasi
                                        </button>
                                    @endif

                                    {{-- Tombol Lihat Cerita (Muncul jika sudah Terbit) --}}
                                    @if($book->status === 'published')
                                        <a href="{{ route('book.detail', $book->slug ?? $book->id) }}" wire:navigate target="_blank" class="inline-flex items-center justify-center px-5 py-2 bg-white border border-gray-200 text-gray-600 hover:text-[#FF500A] text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-50 transition-colors shadow-sm">
                                            Lihat Cerita
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
