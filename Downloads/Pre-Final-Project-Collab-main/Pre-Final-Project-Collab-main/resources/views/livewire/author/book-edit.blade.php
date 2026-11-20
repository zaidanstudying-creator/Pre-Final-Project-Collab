<div class="bg-[#F5F6FA] min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Navigasi Kembali --}}
        <div class="mb-6">
            <a href="{{ route('author.books.index') }}" wire:navigate class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#FF500A] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Cerita Saya
            </a>
        </div>

        {{-- Header Form --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Rincian Cerita</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi utama untuk buku <span class="font-bold text-gray-900">"{{ $book->title }}"</span>.</p>
        </div>

        {{-- Card Form --}}
        <div class="bg-white rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.04)] border border-gray-100 p-6 sm:p-8">
            <form wire:submit="update" class="space-y-6">

                {{-- Input Judul --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Judul Cerita</label>
                    <input type="text" wire:model="title"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm text-gray-900 font-bold focus:ring-1 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all placeholder-gray-400 bg-gray-50 focus:bg-white">
                    @error('title') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Input Kategori --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Genre / Kategori</label>
                        <select wire:model="category_id"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm font-semibold text-gray-700 focus:ring-1 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white cursor-pointer" required>
                            <option value="">-- Pilih Genre --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Upload Sampul Buku --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Ganti Sampul (Opsional)</label>
                        <div class="flex items-center gap-4">
                            <input type="file" wire:model="cover_image" accept="image/*"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#FF500A] file:text-white hover:file:bg-[#e04508] transition-all cursor-pointer bg-gray-50 focus:bg-white">

                            {{-- Preview Gambar Mini --}}
                            @if ($cover_image)
                                <div class="w-10 h-14 shrink-0 rounded overflow-hidden shadow-sm border border-gray-200">
                                    <img src="{{ $cover_image->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @elseif ($existing_cover)
                                <div class="w-10 h-14 shrink-0 rounded overflow-hidden shadow-sm border border-gray-200 relative group cursor-help" title="Sampul Saat Ini">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($existing_cover) }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                        </div>
                        <div wire:loading wire:target="cover_image" class="text-[10px] font-bold text-[#FF500A] mt-1.5 uppercase tracking-wider">Mengunggah...</div>
                        @error('cover_image') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Input Sinopsis --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Sinopsis Cerita</label>
                    <textarea wire:model="synopsis" rows="6"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm text-gray-800 leading-relaxed focus:ring-1 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all placeholder-gray-400 resize-y bg-gray-50 focus:bg-white"
                        placeholder="Tuliskan daya tarik utama cerita..."></textarea>
                    @error('synopsis') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('author.books.index') }}" wire:navigate class="w-full sm:w-auto px-6 py-2.5 text-center rounded-full text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-8 py-2.5 rounded-full text-sm font-bold text-white bg-[#FF500A] hover:bg-[#e04508] shadow-sm transition-colors flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                        <span wire:loading wire:target="update">Memperbarui...</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
