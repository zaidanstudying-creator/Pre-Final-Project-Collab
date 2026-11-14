<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="h-full flex flex-col py-8 px-6 overflow-y-auto">

    {{-- Logo --}}
    <div class="mb-12 pl-2">
        <a href="{{ route('home') }}" wire:navigate class="text-2xl font-black tracking-tighter text-white flex items-center gap-2 hover:opacity-80 transition-opacity" title="Kembali ke Halaman Publik Weboo">
            <div class="w-8 h-8 bg-[#FF500A] text-white rounded-lg flex items-center justify-center text-lg shadow-[0_0_15px_rgba(255,80,10,0.4)]">W</div>
            eboo<span class="text-[#FF500A]">.</span>
        </a>
    </div>

    {{-- Menu Navigasi Utama Admin --}}
    <div class="flex-1 space-y-8">

        <div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest pl-2 mb-4">Ruang Kendali</p>
            <nav class="space-y-2">
                @php
                    $linkClass = "flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all ";
                    $activeClass = "bg-[#FF500A]/10 text-[#FF500A] border border-[#FF500A]/20";
                    $inactiveClass = "text-gray-400 hover:bg-gray-800 hover:text-white";
                @endphp

                @auth
                    @if (auth()->user()->isAdmin())
                        {{-- Menu Moderasi Karya --}}
                        <a href="{{ route('admin.moderation.index') }}" wire:navigate class="{{ $linkClass }} {{ request()->routeIs('admin.moderation.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Moderasi Karya
                        </a>

                        {{-- Menu Kelola Kategori/Genre --}}
                        <a href="{{ route('admin.categories.index') }}" wire:navigate class="{{ $linkClass }} {{ request()->routeIs('admin.categories.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Kelola Kategori
                        </a>
                    @endif
                @endauth
            </nav>
        </div>

        {{-- Pintasan Halaman Publik --}}
        <div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest pl-2 mb-4">Pintasan Publik</p>
            <nav class="space-y-2">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Lihat Beranda
                </a>
            </nav>
        </div>

    </div>

    {{-- Menu Setting/Logout di Bawah --}}
    @auth
        <div class="mt-auto border-t border-gray-800 pt-6 space-y-2">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest pl-2 mb-4">Pengaturan</p>

            <button wire:click="logout" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-rose-500 hover:bg-rose-500/10 hover:border hover:border-rose-500/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar Akun
            </button>
        </div>
    @endauth
</div>
