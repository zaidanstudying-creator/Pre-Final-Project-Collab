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
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Rincian Cerita Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi dasar di bawah ini sebelum kamu mulai menulis bab pertama.</p>
        </div>

        {{-- Card Form --}}
        <div class="bg-white rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.04)] border border-gray-100 p-6 sm:p-8">
            <form wire:submit="save" class="space-y-6">

                {{-- Input Judul --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Judul Cerita</label>
                    <input type="text" wire:model="title"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm text-gray-900 focus:ring-1 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all placeholder-gray-400"
                        placeholder="Contoh: Misteri Hilangnya Bintang" required autofocus>
                    @error('title') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Input Kategori (Error @foreach sebelumnya ada di sini, sekarang sudah diperbaiki) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Genre / Kategori</label>
                        <select wire:model="category_id"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm text-gray-900 focus:ring-1 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-white cursor-pointer" required>
                            <option value="">-- Pilih Genre --</option>
                            @foreach (\App\Models\Category::orderBy('name')->get() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Upload Sampul Buku --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Sampul Cerita (Opsional)</label>
                        <input type="file" wire:model="cover_image" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-gray-600 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-all cursor-pointer">
                        <div wire:loading wire:target="cover_image" class="text-[10px] font-bold text-[#FF500A] mt-1 uppercase tracking-wider">Mengunggah gambar...</div>
                        @error('cover_image') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Preview Cover --}}
                @if ($cover_image)
                    <div class="mt-2">
                        <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-widest">Pratinjau Sampul</p>
                        <div class="w-32 aspect-[2/3] rounded-md overflow-hidden shadow-sm border border-gray-200">
                            <img src="{{ $cover_image->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                {{-- Input Sinopsis --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Sinopsis Cerita</label>
                    <textarea wire:model="synopsis" rows="5"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm text-gray-900 focus:ring-1 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all placeholder-gray-400 resize-y"
                        placeholder="Tuliskan deskripsi singkat atau sinopsis yang menarik pembaca..." required></textarea>
                    @error('synopsis') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-400 mt-2">Sinopsis yang menarik akan membantu ceritamu menjangkau lebih banyak pembaca.</p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('author.books.index') }}" wire:navigate class="px-6 py-2.5 rounded-full text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2.5 rounded-full text-sm font-bold text-white bg-[#FF500A] hover:bg-[#e04508] shadow-sm transition-colors flex items-center gap-2">
                        <span wire:loading.remove wire:target="save">Simpan & Lanjut Menulis</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
