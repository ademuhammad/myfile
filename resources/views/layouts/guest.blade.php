<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MYfile LMS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        <div class="min-h-screen flex flex-col md:flex-row">

            <!-- SISI KIRI (Desktop) / SISI ATAS (Mobile) -->
            <!-- Background Biru Gelap #053F5C -->
            <div class="md:w-5/12 bg-[#053F5C] text-white flex flex-col justify-center items-center p-10 relative overflow-hidden min-h-[40vh] md:min-h-screen">

                <!-- Ornamen Awan (Clouds) di Batas Kanan (Untuk Layar Lebar) -->
                <div class="hidden md:block absolute -right-6 top-10 w-24 h-24 bg-white rounded-full"></div>
                <div class="hidden md:block absolute -right-12 top-1/4 w-32 h-32 bg-white rounded-full"></div>
                <div class="hidden md:block absolute -right-16 top-1/2 w-48 h-48 bg-white rounded-full"></div>
                <div class="hidden md:block absolute -right-10 top-3/4 w-32 h-32 bg-white rounded-full"></div>
                <div class="hidden md:block absolute -right-8 bottom-10 w-24 h-24 bg-white rounded-full"></div>

                <!-- Ornamen Awan (Clouds) di Batas Bawah (Untuk Layar HP) -->
                <div class="md:hidden absolute -bottom-6 -left-4 w-20 h-20 bg-white rounded-full"></div>
                <div class="md:hidden absolute -bottom-12 left-1/4 w-32 h-32 bg-white rounded-full"></div>
                <div class="md:hidden absolute -bottom-16 left-1/2 w-40 h-40 bg-white rounded-full"></div>
                <div class="md:hidden absolute -bottom-10 right-4 w-28 h-28 bg-white rounded-full"></div>

                <div class="relative z-10 text-center max-w-sm">
                    <p class="text-lg font-medium mb-3 text-[#9FE7F5]">Selamat Datang di</p>

                    <!-- Ikon/Logo Putih Bundar -->
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg shadow-[#F7AD19]/20">
                        <svg class="w-12 h-12 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>

                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tighter mb-4">MY<span class="text-[#F7AD19]">File.</span></h1>
                    <p class="text-sm text-blue-100 font-light leading-relaxed">
                        Buat akun Anda untuk mengakses fitur kelas online, mengumpulkan tugas harian, dan pantau nilai dalam satu platform yang mudah digunakan!
                    </p>
                </div>
            </div>

            <!-- SISI KANAN (Desktop) / SISI BAWAH (Mobile) -->
            <!-- Form Konten -->
            <div class="md:w-7/12 flex flex-col items-center justify-center p-8 bg-white relative z-0 w-full min-h-[60vh]">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
