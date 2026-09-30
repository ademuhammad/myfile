<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MYfile LMS') }}</title>

        <!-- Fonts (Memastikan variasi ketebalan font termuat) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#F4F7FE]">

        <!-- Pembungkus Utama (Flexbox) untuk Sidebar & Konten -->
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

            <!-- Mengimpor Sidebar (dari navigation.blade.php) -->
            @include('layouts.navigation')

            <!-- Area Konten Utama -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

                <!-- Top Header (Pencarian & Profil) -->
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 sticky top-0 z-10 shadow-sm">
                    <div class="flex items-center">
                        <!-- Tombol Hamburger Mobile -->
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#429EBD] focus:outline-none lg:hidden mr-4 transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <!-- Bilah Pencarian (Desain Modern dengan warna palet baru) -->
                        <div class="hidden sm:block relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" class="w-80 py-2.5 pl-12 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-[#9FE7F5]/50 focus:border-[#429EBD] transition-all text-[#053F5C]" placeholder="Cari materi atau tugas...">
                        </div>
                    </div>

                    <!-- Dropdown Profil & Notifikasi -->
                    <div class="flex items-center space-x-3 sm:space-x-5">
                        <!-- Ikon Notifikasi (Dot menggunakan Kuning F7AD19) -->
                        <button class="relative p-2 text-gray-400 hover:text-[#F7AD19] transition-colors bg-gray-50 rounded-full border border-transparent hover:border-yellow-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-[#F7AD19] border-2 border-white rounded-full"></span>
                        </button>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-700 hover:text-[#429EBD] focus:outline-none transition duration-150 ease-in-out bg-white py-1.5 px-1.5 sm:px-3 rounded-full border border-gray-200 hover:border-[#9FE7F5] shadow-sm">
                                    <!-- Avatar disesuaikan dengan warna Biru Gelap 053F5C -->
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=053F5C&color=fff&rounded=true&bold=true" alt="Avatar" class="w-8 h-8 rounded-full mr-0 sm:mr-3 shadow-sm border border-gray-100">
                                    <div class="text-left hidden sm:block">
                                        <div class="text-sm font-bold text-[#053F5C] leading-tight">{{ Auth::user()->name }}</div>
                                        <div class="text-[11px] font-semibold text-[#429EBD] uppercase tracking-wider mt-0.5">{{ Auth::user()->role === 'guru' ? 'Guru Informatika' : 'Siswa' }}</div>
                                    </div>
                                    <div class="ms-2 hidden sm:block text-gray-400">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-gray-100 sm:hidden">
                                    <div class="text-sm font-bold text-[#053F5C]">{{ Auth::user()->name }}</div>
                                    <div class="text-xs font-semibold text-[#429EBD] mt-1">Akun: {{ Auth::user()->username }}</div>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <!-- Warna merah khusus untuk tombol logout -->
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                        {{ __('Keluar') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Page Content (Halaman yang dipanggil) -->
                <main class="flex-1 p-6 lg:p-8">
                    @isset($header)
                        <div class="mb-8 flex items-center gap-3">
                            <!-- Ornamen aksen kuning di samping judul -->
                            <div class="w-2 h-8 bg-[#F7AD19] rounded-full"></div>
                            <h1 class="text-2xl font-extrabold text-[#053F5C] tracking-tight">{{ $header }}</h1>
                        </div>
                    @endisset
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>
