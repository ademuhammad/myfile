<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Manage Students') }} <span class="text-gray-400 font-medium text-lg ml-2 hidden sm:inline-block">| Kelola Siswa</span>
            </h2>
            <a href="{{ route('guru.users.create') }}" class="bg-[#053F5C] hover:bg-[#429EBD] text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-blue-900/10 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Siswa Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start" role="alert">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Berhasil!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabel Data Siswa -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-16 text-center">No</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">NIS / Username</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $index => $siswa)
                                <tr class="hover:bg-gray-50/50 transition-colors group">

                                    <td class="p-4 text-sm text-gray-500 text-center font-medium">
                                        {{ $users->firstItem() + $index }}
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-50 border border-[#9FE7F5] flex items-center justify-center text-xs font-bold text-[#053F5C] shrink-0">
                                                {{ substr($siswa->name, 0, 1) }}
                                            </div>
                                            <div class="font-extrabold text-[#053F5C] text-base group-hover:text-[#429EBD] transition-colors">{{ $siswa->name }}</div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <span class="text-sm font-bold text-gray-600">{{ $siswa->username }}</span>
                                    </td>

                                    <td class="p-4">
                                        <span class="inline-flex items-center bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md text-xs font-bold border border-gray-200">
                                            {{ $siswa->classroom->name ?? 'Belum Ada Kelas' }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('guru.users.edit', $siswa->id) }}" class="p-2 text-gray-500 bg-gray-100 hover:bg-[#429EBD] hover:text-white rounded-lg transition-colors tooltip" title="Edit Siswa">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <form action="{{ route('guru.users.destroy', $siswa->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus akun siswa ini? Semua data tugasnya juga akan ikut terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-500 bg-red-50 hover:bg-red-500 hover:text-white rounded-lg transition-colors tooltip" title="Hapus Siswa">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-700">Belum Ada Siswa</h4>
                                        <p class="text-gray-500 text-sm mt-1">Anda belum mendaftarkan akun siswa ke dalam sistem.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
