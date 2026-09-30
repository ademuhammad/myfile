<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Assignment Workspace') }} <span class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Ruang Kerja Tugas</span>
            </h2>
            <a href="{{ route('siswa.assignments.index') }}" class="text-gray-500 hover:text-[#053F5C] font-bold text-sm flex items-center transition-colors bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start" role="alert">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div><p class="font-bold text-green-800">Success!</p><p class="text-green-700 text-sm">{{ session('success') }}</p></div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KOLOM KIRI: Informasi & Instruksi Tugas -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-[#429EBD]"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-black text-[#053F5C] mb-4 leading-tight">{{ $assignment->title }}</h3>

                            <div class="space-y-4 border-b border-gray-100 pb-5 mb-5">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center mr-3 shrink-0 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Guru Pengampu</p>
                                        <p class="font-bold text-[#053F5C]">{{ $assignment->teacher->name }}</p>
                                    </div>
                                </div>

                                @php $isOverdue = $assignment->due_date->isPast(); @endphp
                                <div class="flex items-center text-sm">
                                    <div class="w-8 h-8 rounded-full {{ $isOverdue ? 'bg-red-50 text-red-500' : 'bg-yellow-50 text-[#F7AD19]' }} flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-extrabold uppercase tracking-widest {{ $isOverdue ? 'text-red-400' : 'text-yellow-600' }}">Batas Waktu</p>
                                        <p class="font-bold {{ $isOverdue ? 'text-red-600' : 'text-gray-700' }}">{{ $assignment->due_date->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-xs font-extrabold text-[#053F5C] uppercase tracking-widest mb-2">Instruksi:</h4>
                                <div class="prose prose-sm max-w-none text-gray-600 whitespace-pre-wrap leading-relaxed">{{ $assignment->description }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Status Nilai -->
                    @if($submission)
                        <div class="bg-gradient-to-br from-[#053F5C] to-[#1e3f5c] rounded-3xl shadow-lg border border-blue-900/50 p-6 text-white relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 opacity-10">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2zm0-6h2v4h-2z"/></svg>
                            </div>

                            <h4 class="text-xs font-extrabold text-[#9FE7F5] uppercase tracking-widest mb-1">Status Penilaian</h4>

                            <!-- Menampilkan Nilai PG Otomatis (Jika ada) -->
                            @if($submission->pg_score !== null)
                                <div class="mt-3 bg-white/10 rounded-xl p-3 border border-white/20">
                                    <p class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">Skor Pilihan Ganda (Auto)</p>
                                    <div class="flex items-end gap-1 mt-1">
                                        <span class="text-3xl font-black text-[#F7AD19] leading-none">{{ $submission->pg_score }}</span>
                                        <span class="text-sm font-medium text-gray-400 mb-1">/100</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Menampilkan Nilai Akhir dari Guru -->
                            @if($submission->grade !== null)
                                <div class="flex items-end gap-2 mt-4">
                                    <span class="text-5xl font-black text-white leading-none">{{ $submission->grade }}</span>
                                    <span class="text-lg font-medium text-gray-300 mb-1">/100</span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold mt-1">(Nilai Akhir)</p>

                                @if($submission->feedback)
                                    <div class="mt-4 bg-white/10 rounded-xl p-4 backdrop-blur-sm border border-white/10">
                                        <p class="text-[10px] uppercase tracking-widest text-[#F7AD19] font-bold mb-1">Catatan Guru:</p>
                                        <p class="text-sm italic text-gray-200">"{{ $submission->feedback }}"</p>
                                    </div>
                                @endif
                            @elseif($submission->pg_score === null)
                                <p class="text-lg font-bold mt-2 text-yellow-300">Menunggu Penilaian</p>
                                <p class="text-sm text-gray-300 mt-1">Guru belum memberikan nilai akhir.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- KOLOM KANAN: Ruang Kerja (Workspace) & Fullscreen Alpine -->
                <div class="lg:col-span-2"
                     x-data="{
                        tab: '{{ $assignment->multipleChoices->count() > 0 ? 'pg' : (($submission && $submission->file_path && !$submission->code_snippet) ? 'file' : 'text') }}',
                        isFullscreen: false
                     }">

                    <form action="{{ route('siswa.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Wrapper Ruang Kerja -->
                        <div :class="isFullscreen ? 'fixed inset-0 z-[100] bg-[#f4f7fa] flex flex-col p-0 sm:p-4' : 'bg-white shadow-sm rounded-3xl border border-gray-100 flex flex-col overflow-hidden transition-all duration-300'">

                            <!-- Header / Toolbar Workspace -->
                            <div class="bg-gray-50 border-b border-gray-200 px-4 py-3 flex flex-wrap justify-between items-center gap-3" :class="isFullscreen ? 'rounded-t-2xl' : ''">

                                <!-- Tabs -->
                                <div class="flex bg-gray-200/60 p-1 rounded-lg overflow-x-auto">
                                    <!-- Tab Pilihan Ganda -->
                                    @if($assignment->multipleChoices->count() > 0)
                                    <button @click="tab = 'pg'" type="button" :class="tab === 'pg' ? 'bg-white text-[#053F5C] shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'" class="px-4 py-1.5 text-xs sm:text-sm rounded-md transition-all flex items-center whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-1.5 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        Pilihan Ganda
                                    </button>
                                    @endif

                                    <button @click="tab = 'text'" type="button" :class="tab === 'text' ? 'bg-white text-[#053F5C] shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'" class="px-4 py-1.5 text-xs sm:text-sm rounded-md transition-all flex items-center whitespace-nowrap">
                                        Text Editor / Code
                                    </button>

                                    <button @click="tab = 'file'" type="button" :class="tab === 'file' ? 'bg-white text-[#053F5C] shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'" class="px-4 py-1.5 text-xs sm:text-sm rounded-md transition-all flex items-center whitespace-nowrap">
                                        Upload File
                                    </button>
                                </div>

                                <!-- Fullscreen Toggle Button -->
                                <button type="button" @click="isFullscreen = !isFullscreen" class="text-gray-500 hover:text-[#429EBD] bg-white border border-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center shadow-sm shrink-0">
                                    <svg x-show="!isFullscreen" class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                    <svg x-show="isFullscreen" style="display: none;" class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    <span x-text="isFullscreen ? 'Keluar Fullscreen' : 'Layar Penuh'"></span>
                                </button>
                            </div>

                            <!-- Area Konten Workspace -->
                            <div class="bg-[#fbfcfd] flex-1 p-0 flex flex-col overflow-y-auto" :class="isFullscreen ? 'rounded-b-2xl shadow-xl' : 'h-[500px]'">

                                <!-- Tab 0: Pilihan Ganda -->
                                @if($assignment->multipleChoices->count() > 0)
                                    @php
                                        // Mengambil data jawaban lama jika ada
                                        $oldAnswers = ($submission && $submission->pg_answers) ? json_decode($submission->pg_answers, true) : [];
                                    @endphp

                                    <div x-show="tab === 'pg'" class="p-6 md:p-8 space-y-8">
                                        @foreach($assignment->multipleChoices as $index => $pg)
                                            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                                                <div class="flex items-start mb-4">
                                                    <span class="bg-[#053F5C] text-white text-xs font-black w-6 h-6 rounded-full flex items-center justify-center shrink-0 mr-3 mt-0.5">{{ $index + 1 }}</span>
                                                    <p class="font-bold text-[#053F5C] text-base leading-relaxed">{{ $pg->question }}</p>
                                                </div>

                                                <div class="pl-9 space-y-3">
                                                    @foreach(['a' => $pg->option_a, 'b' => $pg->option_b, 'c' => $pg->option_c, 'd' => $pg->option_d] as $optKey => $optValue)
                                                        @php
                                                            $isChecked = isset($oldAnswers[$pg->id]) && $oldAnswers[$pg->id] === $optKey;
                                                        @endphp
                                                        <label class="flex items-center p-3 rounded-xl border {{ $isChecked ? 'border-[#429EBD] bg-blue-50' : 'border-gray-100 bg-gray-50 hover:bg-gray-100' }} cursor-pointer transition-colors group">
                                                            <input type="radio" name="pg_answers[{{ $pg->id }}]" value="{{ $optKey }}" class="text-[#429EBD] focus:ring-[#429EBD] w-4 h-4 border-gray-300" {{ $isChecked ? 'checked' : '' }} required>
                                                            <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-[#053F5C]"><strong class="uppercase mr-1">{{ $optKey }}.</strong> {{ $optValue }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Tab 1: Text Editor -->
                                <div x-show="tab === 'text'" class="flex-1 flex flex-col h-full w-full" style="display: none;">
                                    <textarea name="code_snippet" class="flex-1 w-full h-full p-6 border-0 focus:ring-0 resize-none font-mono text-gray-800 bg-transparent leading-relaxed placeholder-gray-300 text-sm" placeholder="Ketikkan jawaban Anda, esai, atau tempel kode pemrograman di sini...">{{ $submission->code_snippet ?? '' }}</textarea>
                                </div>

                                <!-- Tab 2: File Upload -->
                                <div x-show="tab === 'file'" style="display: none;" class="p-6 md:p-10 flex-1 flex flex-col justify-center items-center">
                                    <div class="w-full max-w-md">
                                        @if($submission && $submission->file_path)
                                            <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-between">
                                                <div class="flex items-center text-[#053F5C]">
                                                    <svg class="w-6 h-6 mr-2 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    <span class="font-bold text-sm">File sudah terunggah</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="border-2 border-dashed border-gray-300 hover:border-[#429EBD] rounded-2xl p-8 bg-white flex flex-col items-center justify-center transition-colors relative text-center group cursor-pointer">
                                            <svg class="w-10 h-10 text-gray-300 group-hover:text-[#429EBD] mb-4 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <input type="file" name="file_upload" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#053F5C] file:text-white hover:file:bg-[#429EBD] transition-colors cursor-pointer text-center">
                                            <p class="text-[10px] text-gray-400 mt-3 font-medium uppercase tracking-widest">Maks 10MB (PDF, ZIP, DOCX)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Submit -->
                            <div class="bg-white border-t border-gray-100 p-4 sm:p-5 flex flex-col sm:flex-row justify-between items-center gap-4 shrink-0" :class="isFullscreen ? 'rounded-b-2xl' : ''">
                                <p class="text-xs text-gray-400 font-medium italic hidden sm:block">
                                    <svg class="w-4 h-4 inline mr-1 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Semua tab (PG, Teks, File) akan disimpan bersamaan.
                                </p>
                                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-[#053F5C] border border-transparent rounded-xl font-bold text-white tracking-wide hover:bg-[#F7AD19] hover:text-[#053F5C] focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition-all shadow-md">
                                    {{ $submission ? 'Perbarui Jawaban' : 'Kirim Jawaban Tugas' }}
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
