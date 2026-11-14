<div class="min-h-[calc(100vh-64px)] relative flex items-center justify-end p-4 sm:p-8 overflow-hidden">

    {{-- Latar Belakang Rak Buku (Full Background Image) --}}
    <div class="absolute inset-0 z-0 bg-gray-900">
        {{-- Gambar Rak Buku Perpustakaan --}}
        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2070&auto=format&fit=crop" alt="Rak Buku Perpustakaan" class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
    </div>

    {{-- Teks Estetik Kiri Bawah (Hanya muncul di Desktop) --}}
    <div class="hidden lg:block absolute bottom-12 left-12 z-10 text-white max-w-xl">
        <h1 class="text-5xl font-black leading-tight tracking-tight drop-shadow-lg mb-2">
            Mulai <br> <span class="text-[#FF500A]">Perjalananmu.</span>
        </h1>
        <p class="text-lg font-medium text-gray-200 drop-shadow-md">Wujudkan imajinasimu menjadi karya yang menginspirasi banyak orang.</p>
    </div>

    {{-- Kartu Form Register (Mengambang di Kanan) --}}
    <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/50 my-auto">

        <div class="mb-6 flex flex-col items-center text-center">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Buat akun baru</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Bergabung dengan jutaan pembaca & penulis Weboo.</p>
        </div>

        <form wire:submit="register" class="space-y-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Nama Lengkap</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white placeholder-gray-300"
                    placeholder="Masukkan namamu..." required autofocus>
                @error('name') <span class="text-xs font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Email kamu</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white placeholder-gray-300"
                    placeholder="contoh@email.com" required>
                @error('email') <span class="text-xs font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Kata Sandi</label>
                    <input type="password" wire:model="password"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white placeholder-gray-300"
                        placeholder="Min. 8 karakter" required>
                    @error('password') <span class="text-[10px] font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Ulangi Sandi</label>
                    <input type="password" wire:model="password_confirmation"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-[#FF500A] focus:border-[#FF500A] outline-none transition-all bg-gray-50 focus:bg-white placeholder-gray-300"
                        placeholder="Ulangi sandi..." required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-gray-900 hover:bg-black text-white font-bold text-sm rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="register">Daftar Akun</span>
                    <span wire:loading wire:target="register">Memproses...</span>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm font-medium text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate class="text-[#FF500A] font-bold hover:underline underline-offset-4">Masuk di sini</a>
            </p>
        </div>

    </div>
</div>
