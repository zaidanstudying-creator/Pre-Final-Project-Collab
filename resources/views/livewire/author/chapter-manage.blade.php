<div class="bg-[#F5F6FA] min-h-screen py-8">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header & Info Buku --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <a href="{{ route('author.books.index') }}" wire:navigate class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#FF500A] transition-colors mb-3">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Cerita Saya
                </a>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight leading-tight">
                    {{ $book->title }}
                </h1>
                <div class="flex items-center gap-3 mt-2 text-xs font-semibold uppercase tracking-wider">
                    <span class="text-[#FF500A]">{{ $book->category->name }}</span>
                    <span class="text-gray-300">&bull;</span>
                    <span class="text-gray-500 flex items-center gap-1.5">
                        Status: <span class="text-gray-900">{{ $book->status }}</span>
                    </span>
                </div>
            </div>

            <div class="shrink-0 flex items-center gap-3">
                <a href="{{ route('book.detail', $book->slug ?? $book->id) }}" wire:navigate target="_blank" class="px-5 py-2.5 bg-white text-gray-700 hover:text-[#FF500A] font-bold rounded-full text-sm transition-colors border border-gray-200 shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat Publik
                </a>
                <a href="{{ route('author.books.index') }}" wire:navigate class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full text-sm transition-colors shadow-sm">
                    Selesai
                </a>
            </div>
        </div>

        {{-- Alert Notifikasi --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-bold flex items-center gap-3">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Kolom Kiri: Sidebar Daftar Bab --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col h-[calc(100vh-200px)] min-h-[600px]">

                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest">Daftar Isi</h2>
                        <span class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-bold rounded-full">
                            {{ $chapters->count() }} Bab
                        </span>
                    </div>

                    <div class="overflow-y-auto flex-grow divide-y divide-gray-100">
                        @forelse ($chapters as $chapter)
                            <div class="group flex flex-col p-4 hover:bg-[#FFF6F3] transition-colors relative">
                                <div class="pr-10">
                                    <span class="block text-[10px] font-black uppercase tracking-widest text-[#FF500A] mb-1">Bab {{ $chapter->chapter_number }}</span>
                                    <h3 class="text-sm font-bold text-gray-900 mb-1 leading-snug">{{ $chapter->title }}</h3>
                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ strip_tags($chapter->content) }}</p>
                                </div>

                                {{-- Action Hover Menu --}}
                                <div class="absolute right-3 top-4 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                    <button wire:click="editChapter({{ $chapter->id }})" title="Edit Bab" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-white bg-white hover:bg-[#FF500A] rounded-full shadow-sm border border-gray-200 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="deleteChapter({{ $chapter->id }})" wire:confirm="Hapus bab ini secara permanen?" title="Hapus Bab" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-white bg-white hover:bg-rose-500 rounded-full shadow-sm border border-gray-200 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center flex flex-col items-center justify-center h-full">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-300 border border-gray-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-sm text-gray-400 font-semibold">Belum ada bab yang ditulis.</p>
                            </div>
                        @endempty
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Kanvas Tulis/Editor --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl p-6 sm:p-10 shadow-sm border border-gray-200 h-[calc(100vh-200px)] min-h-[600px] flex flex-col">

                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-black text-gray-900 uppercase tracking-wide">
                            {{ $isEditing ? '✏️ Edit Bab' : '✍️ Tulis Bab Baru' }}
                        </h2>
                        @if ($isEditing)
                            <button wire:click="resetForm" class="px-4 py-2 text-xs font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors">
                                Batal Edit
                            </button>
                        @endif
                    </div>

                    <form wire:submit="save" class="flex flex-col flex-grow space-y-6">

                        {{-- Header Bab (Nomor & Judul) --}}
                        <div class="flex gap-4">
                            <div class="w-24 shrink-0">
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1.5">No. Bab</label>
                                <input type="number" wire:model="chapter_number"
                                    class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-2.5 text-center text-xl font-black text-[#FF500A] focus:border-[#FF500A] focus:ring-0 transition-colors rounded-t-lg"
                                    placeholder="1">
                                @error('chapter_number') <span class="text-[10px] font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex-grow">
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1.5">Judul Bab</label>
                                <input type="text" wire:model="title"
                                    class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-4 py-2.5 text-xl font-bold text-gray-900 placeholder-gray-400 focus:border-[#FF500A] focus:ring-0 transition-colors rounded-t-lg"
                                    placeholder="Ketikkan judul bab di sini...">
                                @error('title') <span class="text-[10px] font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Area Teks (Editor) --}}
                        <div class="flex-grow flex flex-col relative">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1.5">Isi Cerita</label>
                            <div class="flex-grow border-2 border-gray-100 rounded-xl bg-white focus-within:border-[#FF500A] transition-colors relative overflow-hidden flex flex-col">
                                <textarea wire:model="content"
                                    class="block w-full h-full flex-grow border-0 bg-transparent p-5 text-base sm:text-lg font-serif leading-[1.8] text-gray-800 placeholder-gray-300 focus:ring-0 resize-none overflow-y-auto"
                                    placeholder="Mulai menulis kisahmu dari sini..."></textarea>
                            </div>
                            @error('content') <span class="text-[10px] font-bold text-rose-500 mt-1 block absolute -bottom-5">{{ $message }}</span> @enderror
                        </div>

                        {{-- Footer Aksi --}}
                        <div class="pt-4 flex items-center justify-between">
                            <button type="button" wire:click="resetForm" class="text-sm font-bold text-gray-400 hover:text-gray-900 transition-colors">
                                Bersihkan Kanvas
                            </button>
                            <button type="submit" class="px-8 py-3 bg-[#FF500A] hover:bg-[#e04508] text-white rounded-full text-sm font-bold transition-colors shadow-sm shadow-orange-200 flex items-center gap-2">
                                <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Simpan Perubahan' : 'Terbitkan Bab' }}</span>
                                <span wire:loading wire:target="save">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
