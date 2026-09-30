<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
            {{ __('Teacher Dashboard') }} <span class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Panel Utama Guru</span>
        </h2>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Banner Selamat Datang -->
            <div class="bg-gradient-to-r from-[#053F5C] to-[#429EBD] rounded-3xl p-8 md:p-10 shadow-lg text-white relative overflow-hidden flex items-center justify-between">
                <div class="relative z-10">
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#9FE7F5] mb-2">Selamat Datang Kembali!</h3>
                    <h2 class="text-3xl md:text-4xl font-black mb-2">Bapak/Ibu {{ Auth::user()->name }}</h2>
                    <p class="text-blue-100 font-medium max-w-xl text-sm md:text-base leading-relaxed">
                        Kelola materi pembelajaran, pantau tugas, dan berikan penilaian kepada siswa Anda dengan mudah dan cepat melalui panel kontrol ini.
                    </p>

                    <!-- Quick Actions -->
                    <div class="flex flex-wrap items-center gap-4 mt-8">
                        <a href="{{ route('materials.create') }}" class="inline-flex items-center px-6 py-3 bg-[#F7AD19] text-[#053F5C] font-black rounded-xl hover:bg-yellow-400 transition-colors shadow-lg shadow-yellow-500/20 text-sm uppercase tracking-wide">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Materi
                        </a>
                        <a href="{{ route('assignments.create') }}" class="inline-flex items-center px-6 py-3 bg-white/20 text-white font-black rounded-xl hover:bg-white/30 backdrop-blur-md transition-colors border border-white/30 text-sm uppercase tracking-wide">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Buat Tugas
                        </a>
                    </div>
                </div>

                <!-- Dekorasi Latar Belakang -->
                <div class="hidden lg:block absolute right-0 top-0 h-full w-1/3 opacity-20 pointer-events-none">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="h-full w-full transform scale-150 translate-x-10">
                        <path fill="#FFFFFF" d="M45.7,-76.4C58.9,-69.3,69.1,-55.3,77.5,-40.8C85.9,-26.3,92.5,-11.3,90.4,2.5C88.3,16.4,77.4,29,66.8,40.1C56.1,51.3,45.8,61,33.3,68.4C20.8,75.8,6.2,80.8,-7.8,79.8C-21.7,78.8,-35.1,71.8,-47.9,63.6C-60.7,55.5,-72.9,46.1,-80.5,33.4C-88.1,20.7,-91.1,4.7,-88.4,-10.5C-85.7,-25.8,-77.3,-40.4,-65,-51C-52.6,-61.7,-36.4,-68.4,-21.3,-72.6C-6.2,-76.8,7.9,-78.5,22.4,-77.6C36.9,-76.7,45.7,-76.4,45.7,-76.4Z" transform="translate(100 100)" />
                    </svg>
                </div>
            </div>

            <!-- Kartu Metrik (Statistik) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Metrik 1: Total Kelas -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-[#429EBD] shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-0.5">Total Kelas</p>
                        <h4 class="text-3xl font-black text-[#053F5C] leading-none">{{ $totalClassrooms }}</h4>
                    </div>
                </div>

                <!-- Metrik 2: Total Siswa -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-full bg-purple-50 flex items-center justify-center text-purple-500 shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-0.5">Total Siswa</p>
                        <h4 class="text-3xl font-black text-[#053F5C] leading-none">{{ $totalStudents }}</h4>
                    </div>
                </div>

                <!-- Metrik 3: Materi Dibuat -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center text-green-500 shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-0.5">Materi Dibuat</p>
                        <h4 class="text-3xl font-black text-[#053F5C] leading-none">{{ $totalMaterials }}</h4>
                    </div>
                </div>

                <!-- Metrik 4: Tugas Dibuat -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-full bg-yellow-50 flex items-center justify-center text-[#F7AD19] shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-0.5">Tugas Aktif</p>
                        <h4 class="text-3xl font-black text-[#053F5C] leading-none">{{ $totalAssignments }}</h4>
                    </div>
                </div>

            </div>

            <!-- Section Daftar Kelas -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-[#053F5C] flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Daftar Kelas yang Diampu
                    </h3>
                    <a href="{{ route('guru.classrooms.index') }}" class="text-[11px] font-bold text-[#429EBD] hover:text-[#053F5C] uppercase tracking-widest flex items-center">
                        Kelola Kelas <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    @if($classrooms->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach($classrooms as $kelas)
                                <div class="bg-[#f4f7fa] p-5 rounded-2xl border border-gray-100 hover:border-[#429EBD] transition-colors group">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="bg-white w-10 h-10 rounded-xl flex items-center justify-center text-[#053F5C] font-black shadow-sm group-hover:bg-[#429EBD] group-hover:text-white transition-colors">
                                            {{ substr($kelas->name, 0, 2) }}
                                        </div>
                                        <span class="text-[10px] font-bold bg-white text-gray-500 px-2.5 py-1 rounded-full border border-gray-100">
                                            {{ $kelas->academic_year }}
                                        </span>
                                    </div>
                                    <h4 class="font-extrabold text-[#053F5C] text-lg">{{ $kelas->name }}</h4>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-700">Belum Ada Kelas</h4>
                            <p class="text-gray-500 text-sm mt-1">Anda belum membuat atau mengelola kelas apa pun.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
