<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Manage Assignments') }} <span
                    class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Kelola Tugas</span>
            </h2>
            <a href="{{ route('assignments.create') }}"
                class="bg-[#053F5C] hover:bg-[#429EBD] text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Tugas Baru
            </a>
        </div>
    </x-slot>

    <!-- Bungkus halaman dengan x-data untuk Alpine.js Search -->
    <div class="py-8 md:py-12" x-data="{ searchQuery: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start"
                    role="alert">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-bold text-green-800">Berhasil!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Live Search Bar -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery"
                        placeholder="Cari berdasarkan judul tugas atau nama kelas..."
                        class="w-full pl-12 pr-4 py-3 bg-[#f4f7fa] border-0 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#429EBD] transition-all text-sm font-medium text-[#053F5C] placeholder-gray-400">
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-16 text-center">
                                    No</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul & Detail
                                    Tugas</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Batas Waktu
                                </th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($assignments as $index => $item)
                                <tr class="hover:bg-[#f4f7fe]/50 transition-colors group"
                                    x-show="searchQuery === '' ||
                                            '{{ strtolower($item->title) }}'.includes(searchQuery.toLowerCase()) ||
                                            '{{ strtolower($item->classroom->name ?? 'semua kelas') }}'.includes(searchQuery.toLowerCase())"
                                    x-transition>

                                    <td class="p-4 text-sm text-gray-500 text-center font-medium">
                                        {{ $assignments->firstItem() + $index }}</td>

                                    <td class="p-4">
                                        <div class="font-extrabold text-[#053F5C] text-base">{{ $item->title }}</div>
                                        <div class="text-xs text-gray-400 mt-1 mb-2">
                                            {{ Str::limit(strip_tags($item->description), 50) }}</div>
                                        @if ($item->sub_assignments_count > 0)
                                            <span
                                                class="inline-flex items-center bg-[#f4f7fa] text-[#429EBD] px-2.5 py-1 rounded-md text-[10px] font-bold border border-gray-200">
                                                <svg class="w-3.5 h-3.5 mr-1 text-[#F7AD19]" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                    </path>
                                                </svg>
                                                {{ $item->sub_assignments_count }} Sub Tugas (Pertanyaan)
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md text-xs font-bold border border-gray-200">
                                            {{ $item->classroom->name ?? 'Semua Kelas' }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        @php $isOverdue = $item->due_date->isPast(); @endphp
                                        <div
                                            class="flex items-center text-sm font-bold {{ $isOverdue ? 'text-red-600' : 'text-[#053F5C]' }}">
                                            <svg class="w-4 h-4 mr-1.5 {{ $isOverdue ? 'text-red-500' : 'text-[#F7AD19]' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $item->due_date->format('d M Y - H:i') }}
                                        </div>
                                    </td>

                                    <td class="p-4 text-center">
                                        <div
                                            class="flex items-center justify-center space-x-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('assignments.show', $item->id) }}"
                                                class="p-2 text-[#429EBD] bg-blue-50 hover:bg-[#429EBD] hover:text-white rounded-lg tooltip"><svg
                                                    class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                                    </path>
                                                </svg></a>
                                            <a href="{{ route('assignments.edit', $item->id) }}"
                                                class="p-2 text-gray-500 bg-gray-100 hover:bg-[#053F5C] hover:text-white rounded-lg tooltip"><svg
                                                    class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg></a>
                                            <form action="{{ route('assignments.destroy', $item->id) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Hapus tugas ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-500 bg-red-50 hover:bg-red-500 hover:text-white rounded-lg tooltip"><svg
                                                        class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if ($assignments->hasPages())
                    <div class="p-4 border-t bg-gray-50/50">{{ $assignments->links() }}</div>
                @endif
            </div>

            <!-- Empty State JS -->
            <div x-show="searchQuery !== '' && document.querySelectorAll('[x-show*=\'searchQuery\']:not([style*=\'display: none\'])').length === 0"
                class="text-center py-10" style="display: none;">
                <p class="text-gray-500 font-medium">Tugas dengan keyword "<span x-text="searchQuery"
                        class="font-bold"></span>" tidak ditemukan.</p>
            </div>
        </div>
    </div>
</x-app-layout>
