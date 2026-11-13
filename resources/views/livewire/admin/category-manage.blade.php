<div class="min-h-screen bg-slate-50 px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Administrasi</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Kategori &amp; genre</h1>
            <p class="mt-2 text-slate-600">Kelola genre yang digunakan untuk mengelompokkan buku.</p>
        </div>

        @if (session('success'))
            <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div role="alert" class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">{{ session('error') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[minmax(280px,0.8fr)_minmax(0,1.5fr)]">
            <section class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-slate-900">{{ $categoryId ? 'Edit kategori' : 'Tambah kategori' }}</h2>
                    <p class="mt-1 text-sm text-slate-500">Slug dibuat otomatis dari nama kategori.</p>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label for="category-name" class="mb-2 block text-sm font-semibold text-slate-700">Nama kategori</label>
                        <input id="category-name" type="text" wire:model="name" maxlength="255" placeholder="Contoh: Fantasi" class="w-full rounded-xl border-slate-300 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex flex-wrap gap-3 pt-1">
                        <button type="submit" wire:loading.attr="disabled" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 disabled:opacity-50">{{ $categoryId ? 'Simpan perubahan' : 'Tambah kategori' }}</button>
                        @if ($categoryId)
                            <button type="button" wire:click="cancelEdit" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                        @endif
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Daftar kategori</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $categories->count() }} kategori tersedia</p>
                    </div>
                </div>
                @if ($categories->isEmpty())
                    <div class="px-6 py-14 text-center">
                        <p class="font-semibold text-slate-800">Belum ada kategori</p>
                        <p class="mt-1 text-sm text-slate-500">Tambahkan kategori pertama melalui formulir.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[540px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                                <tr><th class="px-6 py-3 font-semibold">Kategori</th><th class="px-6 py-3 font-semibold">Slug</th><th class="px-6 py-3 font-semibold">Jumlah buku</th><th class="px-6 py-3 text-right font-semibold">Aksi</th></tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($categories as $category)
                                    <tr wire:key="category-{{ $category->id }}" class="hover:bg-slate-50/70">
                                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $category->name }}</td>
                                        <td class="px-6 py-4 text-slate-500">{{ $category->slug }}</td>
                                        <td class="px-6 py-4"><span class="inline-flex min-w-8 justify-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">{{ $category->books_count }}</span></td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-2">
                                                <button type="button" wire:click="edit({{ $category->id }})" class="rounded-lg px-3 py-1.5 font-semibold text-indigo-700 hover:bg-indigo-50">Edit</button>
                                                <button type="button" wire:click="delete({{ $category->id }})" wire:confirm="Hapus kategori {{ $category->name }}?" class="rounded-lg px-3 py-1.5 font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
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
