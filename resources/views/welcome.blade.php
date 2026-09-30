<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MYfile. by Ade Muhamad Nurhadi</title>

        <!-- Kustomisasi Favicon (Logo di URL Tab tidak lagi menggunakan logo Laravel) -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💻</text></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#f4f7fa] min-h-screen flex flex-col selection:bg-[#F7AD19] selection:text-[#053F5C]">

        <!-- Top Navigation -->
        <header class="w-full bg-white shadow-sm border-b border-gray-100 py-4 px-6 md:px-12 flex justify-between items-center relative z-20">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#053F5C] rounded-xl flex items-center justify-center shadow-md shadow-blue-900/20">
                    <svg class="w-6 h-6 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-[#053F5C] tracking-tight leading-none">MY<span class="text-[#F7AD19]">File.</span></h1>
                    <p class="text-[9px] font-bold text-[#429EBD] uppercase tracking-widest mt-0.5">by Ade muhamad nurhadi</p>
                </div>
            </div>

            <!-- Auth Links -->
            @if (Route::has('login'))
                <nav class="flex items-center gap-2 md:gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-[#053F5C] text-white text-sm font-bold rounded-xl hover:bg-[#429EBD] transition-all shadow-md shadow-blue-900/20 focus:ring-4 focus:ring-[#9FE7F5]">
                            Dashboard &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#053F5C] font-bold text-sm hover:text-[#429EBD] transition-colors px-3 py-2">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-[#F7AD19] text-[#053F5C] text-sm font-bold rounded-xl hover:bg-yellow-400 transition-all shadow-md shadow-yellow-500/20 focus:ring-4 focus:ring-yellow-200 hidden sm:inline-flex">
                                Create Account
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Hero Section -->
        <main class="flex-grow flex items-center justify-center relative overflow-hidden px-6 py-12">

            <!-- Ornamen Background -->
            <div class="absolute top-1/4 left-10 w-72 h-72 bg-[#9FE7F5] rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-1/3 right-10 w-72 h-72 bg-[#F7AD19] rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/3 w-72 h-72 bg-[#429EBD] rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

            <div class="relative z-10 max-w-3xl mx-auto text-center">

                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-[#429EBD] text-xs font-bold uppercase tracking-wider mb-8">
                    <span class="w-2 h-2 rounded-full bg-[#F7AD19] animate-pulse"></span>
                    Informatics Learning Portal
                </div>

                <!-- Judul Utama (Inggris) -->
                <h2 class="text-4xl md:text-6xl font-black text-[#053F5C] mb-6 leading-tight tracking-tight">
                    Learn, Code, and <br class="hidden md:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#429EBD] to-[#053F5C]">Submit Easily.</span>
                </h2>

                <!-- Sub-judul / Deskripsi Bilingual -->
                <div class="space-y-3 mb-10 max-w-2xl mx-auto">
                    <p class="text-lg md:text-xl text-gray-600 font-medium">
                        Welcome to MYfile. The central hub for your computer science class to access materials and track assignments.
                    </p>
                    <p class="text-sm md:text-base text-gray-500 font-normal italic">
                        Selamat datang di MYfile. Pusat pembelajaran kelas informatika untuk mengakses materi dan mengumpulkan tugas.
                    </p>
                </div>

                <!-- Tombol CTA Utama -->
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-8 py-4 bg-[#053F5C] border border-transparent rounded-2xl font-bold text-white tracking-wide hover:bg-[#429EBD] transition-all duration-300 shadow-xl shadow-blue-900/20 text-lg hover:-translate-y-1">
                            Go to My Classroom
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3.5 bg-[#053F5C] border border-transparent rounded-xl font-bold text-white tracking-wide hover:bg-[#429EBD] transition-all duration-300 shadow-lg shadow-blue-900/20 text-base">
                                Log In to Classroom
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3.5 bg-white border-2 border-[#053F5C] rounded-xl font-bold text-[#053F5C] tracking-wide hover:bg-gray-50 transition-all duration-300 text-base">
                                    Register Account
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif

            </div>
        </main>

        <!-- Footer Bilingual -->
        <footer class="w-full py-6 text-center relative z-20 border-t border-gray-100 bg-white">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                &copy; {{ date('Y') }} MYfile. All rights reserved.
            </p>
        </footer>

    </body>
</html>
