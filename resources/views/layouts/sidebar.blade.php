@php
    $user = Auth::user();
    $pendingTasks = 0;
    $ungradedSubmissions = 0;

    if ($user->role === 'siswa' && $user->classroom_id) {
        $totalAssignments = \App\Models\Assignment::where('classroom_id', $user->classroom_id)->count();
        $completed = \App\Models\Submission::where('user_id', $user->id)->count();
        $pendingTasks = max(0, $totalAssignments - $completed);
    } elseif ($user->role === 'guru') {
        $ungradedSubmissions = \App\Models\Submission::whereHas('assignment', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereNull('grade')->count();
    }
@endphp

<!-- Mobile Overlay Layer -->
<div x-show="sidebarMobileOpen" @click="sidebarMobileOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-[#053F5C]/60 z-20 lg:hidden" style="display: none;"></div>

<!-- Sidebar Container -->
<aside :class="[sidebarMobileOpen ? 'translate-x-0' : '-translate-x-full', sidebarDesktopOpen ? 'lg:translate-x-0' : 'lg:-translate-x-full']"
       class="fixed inset-y-0 left-0 z-50 w-[260px] bg-white flex flex-col border-r border-gray-200 transition-transform duration-300 ease-in-out shadow-sm lg:shadow-none">

    <!-- Branding Header -->
    <div class="bg-[#053F5C] pt-10 pb-8 flex flex-col items-center justify-center text-white shrink-0 rounded-br-[40px] shadow-lg relative overflow-hidden group">

        <!-- TOMBOL HAMBURGER (HIDE SIDEBAR) -->
        <button @click="sidebarDesktopOpen = false; sidebarMobileOpen = false"
                class="absolute top-4 right-4 p-2 bg-white/10 hover:bg-[#F7AD19] text-white hover:text-[#053F5C] rounded-lg backdrop-blur-sm transition-all focus:outline-none z-20 shadow-sm"
                title="Tutup Menu Sidebar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Lingkaran Ornamen dekorasi -->
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-[#429EBD] opacity-40 rounded-full blur-md pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-6 w-28 h-28 bg-[#F7AD19] opacity-20 rounded-full blur-md pointer-events-none"></div>

        <!-- Ikon Toga Topi Sarjana -->
        <svg class="w-14 h-14 mb-3 text-[#F7AD19] relative z-10 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>

        <!-- Nama Aplikasi -->
        <h1 class="text-3xl font-extrabold tracking-tight relative z-10">
            MY<span class="text-[#F7AD19]">File.</span>
        </h1>
        <p class="text-[10px] text-[#9FE7F5] mt-1 text-center font-bold relative z-10 tracking-widest uppercase">E-Learning System</p>
    </div>

    <!-- Navigasi Menu Sidebar -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5 text-sm font-semibold">

        <!-- Dashboard Utama -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') || request()->routeIs('guru.dashboard') || request()->routeIs('siswa.dashboard') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') || request()->routeIs('guru.dashboard') || request()->routeIs('siswa.dashboard') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        <!-- Menu Guru -->
        @if($user->role === 'guru')
            <div class="pt-5 pb-2 px-4 text-[10px] font-extrabold text-[#429EBD] uppercase tracking-widest">Class Management</div>

            <a href="{{ route('guru.classrooms.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('guru.classrooms.*') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('guru.classrooms.*') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Manage Classrooms
            </a>

            <a href="{{ route('materials.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('materials.*') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('materials.*') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Manage Materials
            </a>

            <a href="{{ route('assignments.index') }}" class="flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('assignments.*') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('assignments.*') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Manage Assignments
                </div>
                @if($ungradedSubmissions > 0)
                    <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm animate-pulse">{{ $ungradedSubmissions }}</span>
                @endif
            </a>

            <a href="{{ route('guru.users.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('guru.users.*') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('guru.users.*') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Manage Students
            </a>
        @endif

        <!-- Menu Siswa -->
        @if($user->role === 'siswa')
            <div class="pt-5 pb-2 px-4 text-[10px] font-extrabold text-[#429EBD] uppercase tracking-widest">My Learning</div>

            <a href="{{ route('siswa.materials.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('siswa.materials.*') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('siswa.materials.*') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Learning Materials
            </a>

            <a href="{{ route('siswa.assignments.index') }}" class="flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('siswa.assignments.*') ? 'bg-[#053F5C] text-[#F7AD19] shadow-lg shadow-[#053F5C]/30 ring-1 ring-[#053F5C]' : 'text-gray-500 hover:bg-[#9FE7F5]/20 hover:text-[#053F5C]' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('siswa.assignments.*') ? 'text-[#F7AD19]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Assignments
                </div>
                @if($pendingTasks > 0)
                    <span class="bg-[#F7AD19] text-[#053F5C] text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $pendingTasks }}</span>
                @endif
            </a>
        @endif
    </div>

    <!-- Bagian Bawah Sidebar (Tombol Keluar) -->
    <div class="p-4 mb-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-500 hover:bg-red-50 hover:text-red-700 rounded-xl transition-colors font-bold text-sm border border-transparent hover:border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>
