<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            <!-- Sisi Kiri: Tombol Menu Toggle -->
            <div class="flex items-center gap-4">
                <!-- Hamburger Menu (Mobile & Desktop) -->
                <button @click="sidebarMobileOpen = !sidebarMobileOpen" class="lg:hidden p-2 rounded-xl text-gray-500 hover:text-[#053F5C] hover:bg-[#f4f7fa] transition-colors focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <button @click="sidebarDesktopOpen = !sidebarDesktopOpen" class="hidden lg:flex p-2 rounded-xl text-gray-400 hover:text-[#053F5C] hover:bg-[#f4f7fa] transition-colors focus:outline-none" title="Sembunyikan/Tampilkan Menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="sidebarDesktopOpen ? 'hidden' : 'block'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="sidebarDesktopOpen ? 'block' : 'hidden'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
            </div>

            <!-- Sisi Kanan: Profil Dropdown -->
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="flex items-center">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 pl-2 pr-1 py-1.5 border border-transparent rounded-full text-gray-700 hover:bg-[#f4f7fa] focus:outline-none transition-all duration-200 group">
                                <div class="text-right hidden md:block">
                                    <div class="text-[#053F5C] text-sm font-extrabold">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-widest font-black">{{ Auth::user()->role }}</div>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#053F5C] to-[#429EBD] flex items-center justify-center text-white shadow-md group-hover:shadow-lg transition-all border-2 border-white">
                                    <span class="font-bold text-sm tracking-widest">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-sm font-black text-[#053F5C] truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-500 font-extrabold uppercase tracking-widest mt-0.5 truncate">ID: {{ Auth::user()->username }}</p>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="hover:bg-red-50 hover:text-red-600 font-semibold text-sm transition-colors py-2.5 group">
                                        Keluar Sistem
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
