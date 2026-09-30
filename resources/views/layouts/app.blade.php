<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MyFile e-Learning') }}</title>

        <!-- Fonts & Scripts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f4f7fa] text-gray-800 overflow-x-hidden">

        <!-- ALPINE JS WRAPPER -->
        <div x-data="{ sidebarMobileOpen: false, sidebarDesktopOpen: true }" class="min-h-screen bg-[#f4f7fa]">

            <!-- Sidebar Component -->
            @include('layouts.sidebar')

            <!-- Main Content Area (Merespons Sidebar dengan Padding) -->
            <div class="flex flex-col min-h-screen transition-all duration-300 ease-in-out"
                 :class="sidebarDesktopOpen ? 'lg:pl-[260px]' : 'lg:pl-0'">

                <!-- Navigation Top Bar -->
                @include('layouts.navigation')

                <!-- Page Header (Optional) -->
                @isset($header)
                    <header class="bg-white/50 backdrop-blur-sm border-b border-gray-100">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>
