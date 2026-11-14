<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Panel - {{ config('app.name', 'Weboo') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            /* Kustomisasi Scrollbar untuk Admin */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        </style>
    </head>

    {{-- Selection diblok warna Oranye Wattpad --}}
    <body class="font-sans antialiased bg-[#F5F6FA] text-gray-900 selection:bg-[#FF500A] selection:text-white overflow-hidden">

        <div class="flex h-screen w-full">

            {{-- Sidebar Kiri (Diubah ke Tema Gelap Eksklusif ala Foto ke-9) --}}
            <div class="hidden lg:flex w-[280px] shrink-0 h-full bg-[#1A1A1D] border-r border-gray-900 relative z-30 shadow-[4px_0_24px_rgba(0,0,0,0.1)] flex-col transition-all">
                <livewire:layout.sidebar />
            </div>

            {{-- Konten Kanan --}}
            <div class="flex-1 flex flex-col h-full overflow-hidden relative bg-[#F5F6FA]">

                {{-- Topbar Admin --}}
                <div class="z-20 bg-white shadow-sm border-b border-gray-200">
                    <livewire:layout.topbar />
                </div>

                {{-- Area Konten Utama --}}
                <main class="flex-1 overflow-y-auto overflow-x-hidden w-full relative scroll-smooth">
                    {{ $slot }}
                </main>

            </div>
        </div>

    </body>
</html>
