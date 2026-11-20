<div x-data="{ mobileMenuOpen: false }" class="h-20 shrink-0 bg-transparent flex items-center justify-between px-6 lg:px-8 relative z-10 mt-2">

    {{-- Search Bar Palsu (Sesuai Desain) --}}
    <div class="hidden md:flex flex-1 max-w-xl">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-3 border-0 bg-white rounded-2xl leading-5 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] sm:text-sm" placeholder="Search your book...">
        </div>
    </div>

    {{-- Kanan Topbar (Profil User) --}}
    <div class="flex items-center gap-4 ml-auto">
        @auth
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] border border-slate-50 cursor-pointer hover:bg-slate-50 transition-colors">
                <div class="w-8 h-8 rounded-full overflow-hidden bg-indigo-100">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6B50FF&color=fff" class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-bold text-slate-700 hidden sm:block">{{ auth()->user()->name }}</span>
            </div>
        @else
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors mr-2">Masuk</a>
            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#6B50FF] text-white rounded-full text-sm font-bold hover:bg-indigo-700 transition-colors shadow-md">Daftar Akun</a>
        @endauth

        {{-- Hamburger Button (Hanya muncul di Mobile) --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-white shadow-sm">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    {{-- Mobile Menu Modal (Sederhana) --}}
    <div x-show="mobileMenuOpen" style="display: none;" class="lg:hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm">
        <div class="absolute right-0 top-0 bottom-0 w-64 bg-white shadow-xl p-6 flex flex-col" @click.outside="mobileMenuOpen = false">
            <button @click="mobileMenuOpen = false" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-8 space-y-4">
                <a href="{{ route('home') }}" class="block text-slate-700 font-bold">Katalog Buku</a>
                @auth
                    <a href="{{ route('author.books.index') }}" class="block text-slate-700 font-bold">Studio Penulis</a>
                    <a href="{{ route('bookmarks.index') }}" class="block text-slate-700 font-bold">Rak Bacaan</a>
                @endauth
            </div>
        </div>
    </div>
</div>
