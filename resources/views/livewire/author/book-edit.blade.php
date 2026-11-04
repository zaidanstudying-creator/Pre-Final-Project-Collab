<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
    <div class="mb-6">
        <a href="{{ route('author.books.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Studio</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Edit Buku: {{ $book->title }}</h1>
    </div>

    <form wire:submit="update" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6 shadow-sm">
        <div>
            <label class="block text-sm font-medium text-gray-700">Judul Buku</label>
            <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('title') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori / Genre</label>
            <select wire:model="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">Pilih Kategori...</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Sinopsis Cerita</label>
            <textarea wire:model="synopsis" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
            @error('synopsis') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Sampul Buku (Cover Image)</label>
            <input type="file" wire:model="cover_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('cover_image') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror

            <div class="mt-3 flex items-center gap-4">
                @if ($cover_image)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Cover Baru:</p>
                        <img src="{{ $cover_image->temporaryUrl() }}" class="w-24 h-36 object-cover rounded-md border border-gray-200">
                    </div>
                @elseif ($existing_cover)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Cover Saat Ini:</p>
                        <img src="{{ asset('storage/' . $existing_cover) }}" class="w-24 h-36 object-cover rounded-md border border-gray-200">
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('author.books.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition flex items-center gap-2">
                <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                <span wire:loading wire:target="update">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
