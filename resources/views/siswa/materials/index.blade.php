<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
            {{ __('Learning Materials') }} <span class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Materi Pembelajaran</span>
        </h2>
    </x-slot>

    <!-- Bungkus seluruh halaman dengan Alpine.js data -->
    <div class="py-8 md:py-12" x-data="{ searchQuery: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(!$user->classroom_id)
                <!-- Empty State: Belum ada kelas -->
                <div class="bg-yellow-50 border-l-4 border-[#F7AD19] p-6 rounded-r-2xl shadow-sm flex items-start space-x-4">
                    <svg class="w-6 h-6 text-[#F7AD19] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h3 class="text-[#053F5C] font-bold text-lg">No Classroom Assigned</h3>
                        <p class="text-gray-600 text-sm mt-1">You have not been assigned to any classroom yet. Please contact your teacher or administrator.</p>
                    </div>
                </div>
            @elseif($materials->isEmpty())
                <!-- Empty State: Belum ada materi -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-[#f4f7fe] rounded-full flex items-center justify-center mb-5 border border-blue-50">
                        <svg class="w-10 h-10 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#053F5C]">Belum Ada Materi</h3>
                    <p class="text-gray-500 mt-2 max-w-md font-medium">Guru Anda belum memposting materi untuk kelas ini.</p>
                </div>
            @else
                <!-- Toolbar Pencarian JS -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <!-- Input Alpine.js: update variabel searchQuery secara real-time -->
                        <input type="text" x-model="searchQuery" placeholder="Cari berdasarkan judul, topik, atau nama guru..."
                            class="w-full pl-12 pr-4 py-3 bg-[#f4f7fa] border-0 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#429EBD] transition-all text-sm font-medium text-[#053F5C] placeholder-gray-400">
                    </div>
                </div>

                <!-- Daftar Kartu Materi -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($materials as $materi)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group flex flex-col h-full"
                             x-show="searchQuery === '' ||
                                     '{{ strtolower($materi->title) }}'.includes(searchQuery.toLowerCase()) ||
                                     '{{ strtolower($materi->topic ?? '') }}'.includes(searchQuery.toLowerCase()) ||
                                     '{{ strtolower($materi->teacher->name ?? '') }}'.includes(searchQuery.toLowerCase())"
                             x-transition>

                            <!-- Aksen garis atas melayang -->
                            <div class="absolute top-0 left-0 w-full h-1.5 bg-[#429EBD] group-hover:bg-[#053F5C] transition-colors duration-300"></div>

                            <div class="flex-1 mt-2">
                                <!-- Topik & Judul -->
                                <span class="text-[10px] font-extrabold text-[#F7AD19] uppercase tracking-widest">{{ $materi->topic ?? 'Materi Umum' }}</span>
                                <h4 class="font-black text-xl text-[#053F5C] mt-1 group-hover:text-[#429EBD] transition-colors leading-tight">{{ $materi->title }}</h4>

                                <!-- Info Guru & Waktu -->
                                <div class="flex items-center justify-between text-xs text-gray-500 mt-4 mb-4 font-medium border-b border-gray-50 pb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $materi->teacher->name ?? 'Teacher' }}
                                    </div>
                                    <div class="text-gray-400">
                                        {{ $materi->created_at->format('d M Y') }}
                                    </div>
                                </div>

                                <!-- Isi Singkat -->
                                <p class="text-sm text-gray-600 leading-relaxed mb-6">
                                    {{ Str::limit(strip_tags($materi->content), 80) }}
                                </p>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="mt-auto">
                                @if($materi->attachment_path)
                                    <div class="flex gap-2">
                                        <a href="{{ route('materials.view', $materi->id) }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-[#f4f7fe] text-[#053F5C] rounded-xl font-bold text-xs hover:bg-[#429EBD] hover:text-white transition-all border border-blue-50">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            View
                                        </a>
                                        <a href="{{ route('materials.download', $materi->id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-[#053F5C] text-white rounded-xl font-bold text-xs hover:bg-[#F7AD19] hover:text-[#053F5C] transition-all shadow-md shadow-blue-900/10">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-gray-50 text-gray-500 rounded-xl px-4 py-2.5 text-xs font-bold text-center border border-gray-100">
                                        Tidak Ada File Lampiran
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pesan Kosong Alpine.js jika pencarian tidak cocok -->
                <div x-show="searchQuery !== '' && document.querySelectorAll('[x-show*=\'searchQuery\']:not([style*=\'display: none\'])').length === 0"
                     class="text-center py-10" style="display: none;">
                    <p class="text-gray-500 font-medium">Tidak ada materi yang cocok dengan pencarian "<span x-text="searchQuery" class="font-bold text-[#053F5C]"></span>".</p>
                </div>

                <!-- Pagination -->
                @if(method_exists($materials, 'hasPages') && $materials->hasPages())
                    <div class="mt-8">
                        {{ $materials->links() }}
                    </div>
                @endif

            @endif

        </div>
    </div>
</x-app-layout>
