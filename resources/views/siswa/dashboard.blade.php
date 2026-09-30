<x-app-layout>
    <x-slot name="header">
        Student Dashboard
    </x-slot>

    <!-- Welcome Banner dengan Info Siswa -->
    <div class="mb-8 bg-[#053F5C] rounded-2xl p-8 shadow-lg relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <!-- Dekorasi Background -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#429EBD] rounded-full mix-blend-screen opacity-50 blur-2xl"></div>
        <div class="absolute right-20 -bottom-10 w-32 h-32 bg-[#F7AD19] rounded-full mix-blend-screen opacity-30 blur-xl"></div>
        <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-[#9FE7F5] rounded-full mix-blend-screen opacity-20 blur-2xl"></div>

        <div class="relative z-10 text-white">
            <h2 class="text-3xl font-extrabold mb-2 tracking-tight">Welcome back, {{ $user->name }}! 🚀</h2>

            <!-- Badge Info Profil -->
            <div class="flex flex-wrap items-center gap-3 text-sm font-medium mt-3">
                <span class="bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur-sm border border-white/20 shadow-sm">
                    Student ID: <span class="text-[#F7AD19] tracking-wider">{{ $user->username }}</span>
                </span>
                <span class="bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur-sm border border-white/20 shadow-sm">
                    Classroom: <span class="text-[#9FE7F5]">{{ $user->classroom ? $user->classroom->name : 'Unassigned' }}</span>
                </span>
            </div>
        </div>

        <!-- Ikon Ornamen -->
        <div class="relative z-10 hidden md:block">
            <div class="bg-white/10 p-4 rounded-full backdrop-blur-sm border border-white/20 shadow-inner">
                <svg class="w-12 h-12 text-[#9FE7F5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
            </div>
        </div>
    </div>

    <!-- Kotak Menu Interaktif (Quick Links) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Learning Materials Card -->
        <a href="{{ route('siswa.materials.index') }}" class="block p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-[#429EBD] group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-[#9FE7F5]/40 to-transparent rounded-bl-full z-0 transition-transform duration-300 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-5 group-hover:bg-[#429EBD] transition-colors duration-300">
                    <svg class="w-7 h-7 text-[#429EBD] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h4 class="text-xl font-extrabold text-[#053F5C] mb-2">Learning Materials</h4>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">
                    Access all course materials, modules, and coding files shared by your teacher.
                </p>
            </div>
        </a>

        <!-- Assignments Card -->
        <a href="{{ route('siswa.assignments.index') }}" class="block p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-[#F7AD19] group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-[#F7AD19]/20 to-transparent rounded-bl-full z-0 transition-transform duration-300 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-full bg-yellow-50 flex items-center justify-center mb-5 group-hover:bg-[#F7AD19] transition-colors duration-300">
                    <svg class="w-7 h-7 text-[#F7AD19] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h4 class="text-xl font-extrabold text-[#053F5C] mb-2">Assignments & Tasks</h4>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">
                    Check pending tasks, view deadlines, and submit your coding assignments easily.
                </p>
            </div>
        </a>

    </div>
</x-app-layout>
