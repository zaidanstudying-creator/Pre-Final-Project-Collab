<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Weboo') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- PENTING: Wajib ditambahkan agar animasi Dropdown & Filter berfungsi --}}
        @livewireStyles
        <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    </head>

    {{-- Mengubah warna selection (blok teks) menjadi Oranye --}}
    <body class="font-sans antialiased bg-[#F5F6FA] text-gray-900 selection:bg-[#FF500A] selection:text-white">

        <div class="min-h-screen flex flex-col">
            {{-- Top Navbar untuk Halaman Publik --}}
            <livewire:layout.navigation />

            <main class="flex-grow w-full">
                {{ $slot }}
            </main>
        </div>

        {{-- PENTING: Wajib ditambahkan agar klik tombol merespons --}}
        @livewireScripts
    </body>
</html>
