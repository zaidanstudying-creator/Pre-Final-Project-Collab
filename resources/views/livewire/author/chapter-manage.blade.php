<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Header & Info Buku --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <a href="{{ route('author.books.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Daftar Buku</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">Kelola Bab: {{ $book->title }}</h1>
            <p class="text-sm text-gray-500">Status: <span class="font-semibold uppercase">{{ $book->status }}</span> &bull; Kategori: {{ $book->category->name }}</p>
        </div>
        <div>
            <a href="{{ route('author.books.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Selesai Mengedit
            </a>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Daftar Bab yang Sudah Dibuat --}}
        <div class="lg:col-span-1 space-y-4">
            <h2 class="text-lg font-bold text-gray-900 flex items-center justify-between">
                <span>Daftar Bab</span>
                <span class="text-xs bg-gray-200 text-gray-700 font-semibold px-2 py-0.5 rounded-full">{{ $chapters->count() }} Bab</span>
            </h2>

            <div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100 shadow-sm overflow-hidden max-h-[600px] overflow-y-auto">
                @forelse ($chapters as $chapter)
                    <div class="p-4 hover:bg-gray-50 flex items-start justify-between gap-3 transition">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600">Bab {{ $chapter->chapter_number }}</span>
                            <h3 class="text-sm font-medium text-gray-900">{{ $chapter->title }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ Str::limit(strip_tags($chapter->content), 40) }}</p>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button wire:click="editChapter({{ $chapter->id }})" class="p-1.5 text-gray-500 hover:text-indigo-600 rounded hover:bg-gray-100 text-xs font-medium">
                                Edit
                            </button>
                            <button wire:click="deleteChapter({{ $chapter->id }})" wire:confirm="Hapus bab ini?" class="p-1.5 text-gray-400 hover:text-rose-600 rounded hover:bg-gray-100 text-xs font-medium">
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-400">
                        Belum ada bab. Tambahkan bab pertama melalui formulir di samping.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Kolom Kanan: Form Tambah / Edit Bab --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ $isEditing ? 'Perbarui Bab Cerita' : 'Tulis Bab Baru' }}
                    </h2>
                    @if ($isEditing)
                        <button wire:click="resetForm" class="text-xs text-gray-500 hover:text-gray-800 underline">
                            Batalkan Mode Edit
                        </button>
                    @endif
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div class="sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Nomor Bab</label>
                            <input type="number" wire:model="chapter_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('chapter_number') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Judul Bab</label>
                            <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: Awal Perjumpaan">
                            @error('title') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Isi Naskah Bab</label>
                        <textarea wire:model="content" rows="14" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-serif leading-relaxed" placeholder="Ketikkan isi cerita bab di sini..."></textarea>
                        @error('content') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" wire:click="resetForm" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Bersihkan Form
                        </button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Simpan Perubahan' : 'Tambahkan Bab' }}</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
