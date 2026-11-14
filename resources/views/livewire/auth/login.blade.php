<div class="min-h-[calc(100vh-64px)] relative flex items-center justify-end p-4 sm:p-8 overflow-hidden">

    {{-- Latar Belakang Perpustakaan (Full Background Image) --}}
    <div class="absolute inset-0 z-0 bg-gray-900">
        {{-- Gambar Perpustakaan Estetik --}}
        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2070&auto=format&fit=crop" alt="Perpustakaan Estetik" class="w-full h-full object-cover opacity-80">
        {{-- Overlay gelap agar teks dan form tetap mudah dibaca --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
    </div>

    {{-- Teks Estetik Kiri Bawah (Hanya muncul di Desktop) --}}
    <div class="hidden lg:block absolute bottom-12 left-12 z-10 text-white max-w-xl">
        <h1 class="text-5xl font-black leading-tight tracking-tight drop-shadow-lg mb-2">
            Masuki dunia <br> <span class="text-[#FF500A]">tanpa batas.</span>
        </h1>
        <p class="text-lg font-medium text-gray-200 drop-shadow-md">Akses pusat ruang baca dan tulisan pribadimu.</p>
    </div>

    {{-- Kartu Form Login (Mengambang di Kanan) --}}
    <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/50">

        <div class="mb-8 flex flex-col items-center text-center">
            <div class="w-12 h-12 bg-[#FF500A] text-white rounded-xl flex items-center justify-center text-2xl font-black shadow-lg shadow-orange-200 mb-4">
                W
            </div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Selamat Datang</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Masuk untuk melanjutkan membaca.</p>
        </div>

        <form wire:submit="login" class="space-y-5">
            <div>
                <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-1.5">Email kamu</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white placeholder-gray-300"
                    placeholder="contoh@email.com" required autofocus>
                @error('email') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-1.5">Kata Sandi</label>
                <input type="password" wire:model="password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white placeholder-gray-300"
                    placeholder="••••••••" required>
                @error('password') <span class="text-xs font-bold text-rose-500 mt-1.5 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-gray-900 hover:bg-black text-white font-bold text-sm rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="login">Mulai Masuk</span>
                    <span wire:loading wire:target="login">Memeriksa...</span>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm font-medium text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" wire:navigate class="text-[#FF500A] font-bold hover:underline underline-offset-4">Daftar sekarang</a>
            </p>
        </div>

    </div>
</div>
