<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-[#F5F6FA] min-h-screen">

    {{-- Header Admin Kategori --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-8 mb-8 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-gray-900 rounded-full">Dashboard Admin</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kategori & Genre</h1>
            <p class="text-sm font-semibold text-gray-500 mt-2">Kelola daftar genre untuk mempermudah pembaca menemukan buku favorit mereka.</p>
        </div>
        <div class="shrink-0">
            <a href="{{ route('admin.moderation.index') }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-full text-sm transition-all shadow-sm border border-gray-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Moderasi
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-bold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

        {{-- Kolom Kiri: Form Tambah/Edit Kategori --}}
        <div class="lg:col-span-4">
            <section class="bg-white rounded-3xl border border-gray-200 p-8 shadow-sm sticky top-24">
                <div class="mb-8">
                    <h2 class="text-xl font-black text-gray-900">{{ $categoryId ? '✏️ Edit Genre' : '✨ Genre Baru' }}</h2>
                    <p class="mt-2 text-xs font-semibold text-gray-400 leading-relaxed">Tuliskan nama genre baru. Slug URL akan dibuat secara otomatis.</p>
                </div>

                <form wire:submit="save" class="space-y-6">
                    <div>
                        <label for="category-name" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Nama Kategori</label>
                        <input id="category-name" type="text" wire:model="name" maxlength="255"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-4 py-3 text-lg font-bold text-gray-900 placeholder-gray-400 focus:border-[#FF500A] focus:ring-0 transition-colors rounded-t-lg"
                            placeholder="Cth: Sci-Fi, Thriller...">
                        @error('name') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 flex flex-col gap-3">
                        <button type="submit" wire:loading.attr="disabled" class="w-full py-3 bg-[#FF500A] hover:bg-[#e04508] text-white rounded-full text-sm font-bold transition-all shadow-sm flex justify-center items-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="save">{{ $categoryId ? 'Simpan Perubahan' : 'Tambahkan Kategori' }}</span>
                            <span wire:loading wire:target="save">Memproses...</span>
                        </button>

                        @if ($categoryId)
                            <button type="button" wire:click="cancelEdit" class="w-full py-3 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-full text-sm font-bold transition-colors">
                                Batalkan Edit
                            </button>
                        @endif
                    </div>
                </form>
            </section>
        </div>

        {{-- Kolom Kanan: Tabel Daftar Kategori --}}
        <div class="lg:col-span-8">
            <section class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest">Daftar Genre</h2>
                    <span class="px-3 py-1 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-full shadow-sm">
                        Total: {{ $categories->count() }}
                    </span>
                </div>

                @if ($categories->isEmpty())
                    <div class="p-20 text-center flex flex-col items-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6 text-gray-300 border border-gray-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <p class="font-black text-gray-900 text-xl mb-2">Belum Ada Kategori</p>
                        <p class="text-sm text-gray-500 font-semibold">Gunakan form di samping untuk membuat kategori pertama.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 bg-white">
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Nama Genre</th>
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Slug (URL)</th>
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Buku</th>
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($categories as $category)
                                    <tr wire:key="category-{{ $category->id }}" class="group hover:bg-gray-50 transition-colors">
                                        <td class="px-8 py-5">
                                            <span class="font-bold text-gray-900">{{ $category->name }}</span>
                                        </td>
                                        <td class="px-8 py-5">
                                            <span class="text-xs font-semibold text-gray-400 font-mono">{{ $category->slug }}</span>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="inline-flex min-w-[2rem] justify-center rounded-md bg-orange-50 px-2.5 py-1 text-xs font-bold text-[#FF500A]">
                                                {{ $category->books_count }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button type="button" wire:click="edit({{ $category->id }})" title="Edit" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-white hover:bg-gray-900 rounded-full shadow-sm border border-gray-200 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <button type="button" wire:click="delete({{ $category->id }})" wire:confirm="Yakin ingin menghapus genre '{{ $category->name }}'? Ini mungkin berdampak pada buku yang menggunakannya." title="Hapus" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-white hover:bg-rose-500 rounded-full shadow-sm border border-gray-200 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>

    </div>
</div>
