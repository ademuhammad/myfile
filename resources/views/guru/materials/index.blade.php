<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Manage Materials') }} <span class="text-gray-400 font-medium text-lg ml-2 hidden sm:inline-block">| Kelola Materi</span>
            </h2>
            <a href="{{ route('materials.create') }}" class="bg-[#053F5C] hover:bg-[#429EBD] text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-blue-900/10 transition-all flex items-center gap-2 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Materi
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start" role="alert">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Berhasil!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Toolbar Interaktif: Pencarian & Filter -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <form action="{{ route('materials.index') }}" method="GET" class="w-full flex flex-col md:flex-row gap-3">

                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau topik materi..."
                            class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 transition-all text-sm font-medium text-[#053F5C] placeholder-gray-400">
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative w-full md:w-48 shrink-0">
                        <select name="sort" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 transition-all text-sm font-bold text-gray-600 cursor-pointer appearance-none">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Paling Baru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Paling Lama</option>
                            <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>Judul (A-Z)</option>
                            <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Judul (Z-A)</option>
                        </select>
                    </div>

                    <!-- Tombol Cari -->
                    <button type="submit" class="px-5 py-2.5 bg-[#F7AD19] hover:bg-yellow-400 text-[#053F5C] font-bold rounded-xl shadow-sm border border-transparent transition-colors text-sm shrink-0">
                        Cari Data
                    </button>

                    <!-- Tombol Reset (Muncul jika ada pencarian/sort aktif) -->
                    @if(request('search') || request('sort'))
                        <a href="{{ route('materials.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl shadow-sm border border-transparent transition-colors text-sm shrink-0 flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tabel Data Materi -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-16 text-center">No</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Materi & Topik</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Distribusi Kelas</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Lampiran</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($materials as $index => $item)
                                <tr class="hover:bg-[#f4f7fe]/50 transition-colors group">

                                    <!-- Nomor -->
                                    <td class="p-4 text-sm text-gray-500 text-center font-medium">
                                        {{ $materials->firstItem() + $index }}
                                    </td>

                                    <!-- Judul & Topik -->
                                    <td class="p-4 max-w-sm">
                                        <div class="text-[10px] font-extrabold text-[#429EBD] uppercase tracking-widest mb-1">{{ $item->topic ?? 'Umum' }}</div>
                                        <div class="font-black text-[#053F5C] text-base group-hover:text-[#429EBD] transition-colors leading-tight">{{ $item->title }}</div>
                                        <div class="text-xs text-gray-400 mt-1.5 truncate">{{ Str::limit(strip_tags($item->content), 60) }}</div>
                                    </td>

                                    <!-- Multi Kelas -->
                                    <td class="p-4">
                                        <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                            @forelse($item->classrooms as $kelas)
                                                <span class="inline-flex items-center bg-gray-100 text-gray-600 px-2 py-1 rounded text-[10px] font-bold border border-gray-200">
                                                    {{ $kelas->name }}
                                                </span>
                                            @empty
                                                <span class="inline-flex items-center bg-yellow-50 text-[#F7AD19] px-2.5 py-1 rounded-md text-[10px] font-bold border border-yellow-100">
                                                    Semua Kelas
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <!-- Lampiran -->
                                    <td class="p-4">
                                        @if($item->attachment_path)
                                            <span class="inline-flex items-center bg-blue-50 text-[#429EBD] px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider border border-blue-100">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-gray-50 text-gray-400 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border border-gray-100">
                                                Tidak Ada
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('materials.edit', $item->id) }}" class="p-2 text-gray-500 bg-gray-100 hover:bg-[#429EBD] hover:text-white rounded-lg transition-colors tooltip" title="Edit Materi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('materials.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus materi ini? File lampiran juga akan terhapus permanen.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-500 bg-red-50 hover:bg-red-500 hover:text-white rounded-lg transition-colors tooltip" title="Hapus Materi">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center">
                                        <div class="w-16 h-16 bg-[#f4f7fa] rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-[#053F5C]">Data Tidak Ditemukan</h4>
                                        <p class="text-gray-500 text-sm mt-1">
                                            {{ request('search') ? 'Coba gunakan kata kunci pencarian yang lain.' : 'Anda belum menambahkan materi pembelajaran apa pun.' }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($materials->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $materials->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
