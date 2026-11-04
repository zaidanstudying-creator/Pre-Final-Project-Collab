<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Studio Karya Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola naskah, bab cerita, dan pantau status publikasi bukumu.</p>
        </div>
        <a href="{{ route('author.books.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition">
            + Tulis Buku Baru
        </a>
    </div>

    @if (session()->has('success'))
        <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($books as $book)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between">
                <div>
                    @if ($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                            Tidak Ada Cover
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                {{ $book->category->name }}
                            </span>
                            @php
                                $statusStyles = [
                                    'draft' => 'bg-gray-100 text-gray-600',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'published' => 'bg-emerald-100 text-emerald-700',
                                    'rejected' => 'bg-rose-100 text-rose-700',
                                ];
                            @endphp
                            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $statusStyles[$book->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst($book->status) }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 line-clamp-1">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $book->synopsis }}</p>

                        @if ($book->status === 'rejected' && $book->admin_notes)
                            <div class="mt-3 p-3 bg-rose-50 border border-rose-200 rounded-md text-xs text-rose-700">
                                <strong>Catatan Admin:</strong> {{ $book->admin_notes }}
                            </div>
                        @endif

                        <p class="text-xs text-gray-400 mt-3">{{ $book->chapters->count() }} Bab Terbit</p>
                    </div>
                </div>

                <div class="p-5 pt-0 border-t border-gray-100 mt-4 flex items-center justify-between gap-2">
                    <a href="{{ route('author.chapters.index', $book) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                        Kelola Bab &rarr;
                    </a>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('author.books.edit', $book) }}" class="text-xs text-gray-600 hover:text-gray-900 border border-gray-300 px-2 py-1 rounded">
                            Edit
                        </a>
                        @if ($book->status === 'draft' || $book->status === 'rejected')
                            <button wire:click="submitForReview({{ $book->id }})" wire:confirm="Ajukan buku ini untuk direview oleh admin?" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-2 py-1 rounded">
                                Ajukan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500">Kamu belum membuat buku cerita.</p>
                <a href="{{ route('author.books.create') }}" class="mt-2 inline-block text-sm text-indigo-600 font-medium hover:underline">
                    Mulai tulis karya pertamamu sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>
