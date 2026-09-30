<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Manage Classrooms') }} <span class="text-gray-400 font-medium text-lg ml-2 hidden sm:inline-block">| Data Kelas</span>
            </h2>
            <a href="{{ route('guru.classrooms.create') }}" class="bg-[#053F5C] hover:bg-[#429EBD] text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-blue-900/10 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kelas Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start" role="alert">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Berhasil!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabel Data Kelas -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-16 text-center">No</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tahun Ajaran</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($classrooms as $index => $kelas)
                                <tr class="hover:bg-gray-50/50 transition-colors group">

                                    <!-- Nomor urut otomatis berlanjut ke halaman berikutnya -->
                                    <td class="p-4 text-sm text-gray-500 text-center font-medium">
                                        {{ $classrooms->firstItem() + $index }}
                                    </td>

                                    <td class="p-4">
                                        <div class="font-extrabold text-[#053F5C] text-base group-hover:text-[#429EBD] transition-colors">{{ $kelas->name }}</div>
                                    </td>

                                    <td class="p-4">
                                        <span class="inline-flex items-center bg-[#f4f7fa] text-gray-600 px-3 py-1.5 rounded-lg text-sm font-bold border border-gray-200">
                                            <svg class="w-4 h-4 mr-1.5 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $kelas->academic_year }}
                                        </span>
                                    </td>

                                    <!-- Tombol Aksi Ikon -->
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                            <!-- Edit -->
                                            <a href="{{ route('guru.classrooms.edit', $kelas->id) }}" class="p-2 text-gray-500 bg-gray-100 hover:bg-[#429EBD] hover:text-white rounded-lg transition-colors tooltip" title="Edit Kelas">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('guru.classrooms.destroy', $kelas->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini? Pastikan tidak ada siswa yang masih terdaftar di kelas ini.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-500 bg-red-50 hover:bg-red-500 hover:text-white rounded-lg transition-colors tooltip" title="Hapus Kelas">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-700">Belum Ada Kelas</h4>
                                        <p class="text-gray-500 text-sm mt-1">Anda belum mendaftarkan data kelas apa pun.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Bagian Pagination (Muncul Otomatis Jika Data > 10) -->
                @if($classrooms->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $classrooms->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
