<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Livewire\Volt\Component;

new class extends Component
{
    public function with(): array
    {
        return [
            'categories' => class_exists(Category::class) ? Category::orderBy('name')->get() : []
        ];
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ mobileMenuOpen: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">

            {{-- BAGIAN KIRI: Logo & Jelajahi --}}
            <div class="flex items-center gap-6 shrink-0">
                <a href="{{ route('home') }}" wire:navigate class="text-2xl font-black tracking-tighter text-[#FF500A] hover:opacity-80 transition-opacity">
                    Weboo<span class="text-gray-900">.</span>
                </a>

                {{-- Dropdown Jelajahi --}}
                <div x-data="{ jelajahiOpen: false }" class="hidden md:block relative" @mouseleave="jelajahiOpen = false">
                    <button type="button" @mouseenter="jelajahiOpen = true" @click="jelajahiOpen = !jelajahiOpen" class="flex items-center gap-1.5 text-sm font-bold text-gray-700 hover:text-[#FF500A] py-5 transition-colors">
                        Jelajahi
                        <svg class="w-4 h-4" :class="{'rotate-180': jelajahiOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: transform 0.2s;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="jelajahiOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute left-0 mt-0 w-[600px] bg-white border border-gray-100 shadow-xl rounded-b-2xl py-6 px-8 z-50">
                        <p class="text-xs font-black tracking-widest text-gray-400 uppercase mb-5 border-b border-gray-100 pb-2">Eksplorasi Genre</p>
                        <div class="grid grid-cols-3 gap-y-4 gap-x-8">
                            @forelse ($categories as $category)
                                {{-- PERBAIKAN 1: Link kategori sekarang membawa ID ke halaman beranda --}}
                                <a href="{{ route('home', ['category' => $category->id]) }}" wire:navigate class="text-sm font-semibold text-gray-700 hover:text-[#FF500A] hover:translate-x-1 transition-all truncate">
                                    {{ $category->name }}
                                </a>
                            @empty
                                <span class="text-sm text-gray-400 font-medium">Belum ada genre</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN TENGAH: Search Bar --}}
            <div class="hidden md:flex flex-1 max-w-2xl px-6">
                {{-- PERBAIKAN 2: Mengubah input menjadi Form Pencarian --}}
                <form action="{{ route('home') }}" method="GET" class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-sm font-medium placeholder-gray-400 focus:bg-white focus:border-[#FF500A] focus:ring-1 focus:ring-[#FF500A] transition-all" placeholder="Telusuri cerita dan penulis...">
                </form>
            </div>

            {{-- BAGIAN KANAN: Tulis & Auth --}}
            <div class="flex items-center gap-2 sm:gap-6 shrink-0">
                @auth
                    <div x-data="{ tulisOpen: false }" class="relative" @click.outside="tulisOpen = false">
                        <button type="button" @click="tulisOpen = !tulisOpen" class="hidden sm:flex items-center gap-1.5 text-sm font-bold text-gray-700 hover:text-[#FF500A] py-2 transition-colors">
                            Tulis
                            <svg class="w-4 h-4" :class="{'rotate-180': tulisOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: transform 0.2s;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="tulisOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 shadow-xl rounded-xl py-2 z-50">
                            <a href="{{ route('author.books.create') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-[#FF500A] transition-colors">
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                Buat Cerita Baru
                            </a>
                            <a href="{{ route('author.books.index') }}" wire:navigate class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors border-t border-gray-100">
                                Cerita Saya (Studio)
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('bookmarks.index') }}" wire:navigate class="hidden sm:block text-sm font-bold text-gray-700 hover:text-[#FF500A] transition-colors">Rak Baca</a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.moderation.index') }}" wire:navigate class="hidden sm:inline-flex items-center justify-center px-3 py-1 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-800 transition-colors shadow-sm">
                            Admin
                        </a>
                    @endif

                    <div x-data="{ profileOpen: false }" class="relative ml-2" @click.outside="profileOpen = false">
                        <button type="button" @click="profileOpen = !profileOpen" class="flex items-center gap-2 focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-sm hover:border-[#FF500A] transition-all">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FF500A&color=fff&font-size=0.35" class="w-full h-full object-cover">
                            </div>
                        </button>
                        <div x-show="profileOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute right-0 mt-3 w-56 bg-white border border-gray-100 shadow-xl rounded-xl py-2 z-50">
                            <div class="px-4 py-3 border-b border-gray-100 mb-1 bg-gray-50/50">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-[#FF500A] mt-1">{{ auth()->user()->role }}</p>
                            </div>
                            <a href="{{ route('profile') }}" wire:navigate class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#FF500A] transition-colors">Profil Saya</a>
                            <button type="button" wire:click="logout" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-colors">Keluar Akun</button>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-[#FF500A] transition-colors hidden sm:block">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#FF500A] text-white text-sm font-bold rounded-full hover:bg-[#e04508] shadow-sm shadow-orange-200 transition-colors">Daftar Gratis</a>
                @endauth

                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full z-40 pb-4">
        <div class="px-4 py-4">
            <form action="{{ route('home') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-full text-sm placeholder-gray-400 focus:bg-white focus:border-[#FF500A]" placeholder="Telusuri cerita...">
            </form>
        </div>

        <div class="px-4 space-y-1">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-2 pt-2 pb-1 border-b border-gray-100 mb-2">Eksplorasi Genre</p>
            @foreach ($categories->take(5) as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" class="block px-2 py-2 text-sm font-bold text-gray-700 hover:text-[#FF500A]">{{ $category->name }}</a>
            @endforeach
            <hr class="my-3 border-gray-100">

            @auth
                <a href="{{ route('author.books.create') }}" class="block px-2 py-2 text-sm font-bold text-gray-700">Tulis Cerita Baru</a>
                <a href="{{ route('author.books.index') }}" class="block px-2 py-2 text-sm font-bold text-gray-700">Cerita Saya (Studio)</a>
                <a href="{{ route('bookmarks.index') }}" class="block px-2 py-2 text-sm font-bold text-gray-700">Rak Baca</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.moderation.index') }}" class="block px-2 py-2 text-sm font-bold text-[#FF500A]">Panel Admin</a>
                @endif
                <hr class="my-3 border-gray-100">
                <a href="{{ route('profile') }}" class="block px-2 py-2 text-sm font-bold text-gray-700">Profil Saya</a>
                <button type="button" wire:click="logout" class="block w-full text-left px-2 py-2 text-sm font-bold text-rose-600">Keluar Akun</button>
            @else
                <a href="{{ route('login') }}" class="block px-2 py-2 text-sm font-bold text-gray-700">Masuk</a>
            @endauth
        </div>
    </div>
</nav>
