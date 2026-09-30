<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Assignment Workspace') }} <span
                    class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Ruang Kerja Tugas</span>
            </h2>
            <a href="{{ route('siswa.assignments.index') }}"
                class="text-gray-500 hover:text-[#053F5C] font-bold text-sm flex items-center transition-colors bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <!-- CSS Tambahan untuk CKEditor & Ace Editor -->
    <style>
        .ck-content ul {
            list-style-type: disc !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1rem !important;
        }

        .ck-content ol {
            list-style-type: decimal !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1rem !important;
        }

        .ck-content a {
            color: #429EBD !important;
            text-decoration: underline !important;
        }

        .ck-content blockquote {
            border-left: 4px solid #429EBD;
            padding-left: 1rem;
            color: #6b7280;
            font-style: italic;
        }

        .ck-editor__editable_inline {
            min-height: 250px;
            border-bottom-left-radius: 1rem !important;
            border-bottom-right-radius: 1rem !important;
        }

        .ck-toolbar {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            background-color: #f4f7fa !important;
            border-color: #e5e7eb !important;
        }

        #ace-editor {
            font-family: 'Fira Code', monospace;
            font-size: 14px;
            border-radius: 1rem;
        }
    </style>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-bold text-green-800">Success!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- 1. BAGIAN INFORMASI TUGAS (1 KOLOM PENUH) -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-[#429EBD]"></div>
                <div class="p-6 md:p-10">
                    <div
                        class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6 mb-8 border-b border-gray-100 pb-8">
                        <div>
                            <h3 class="text-3xl font-black text-[#053F5C] mb-4 leading-tight">{{ $assignment->title }}
                            </h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                                    <div
                                        class="w-6 h-6 rounded-full bg-[#053F5C] flex items-center justify-center mr-2 shrink-0 text-white">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-[#053F5C]">{{ $assignment->teacher->name }}</span>
                                </div>

                                @php $isOverdue =$assignment->due_date->isPast(); @endphp
                                <div
                                    class="flex items-center {{ $isOverdue ? 'bg-red-50 text-red-600 border-red-100' : 'bg-[#f4f7fa] text-[#053F5C] border-blue-50' }} px-4 py-2 rounded-xl border font-bold">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Batas: {{ $assignment->due_date->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Kartu Status Nilai Ringkas -->
                        @if ($submission)
                            <div
                                class="bg-gradient-to-br from-[#053F5C] to-[#1e3f5c] rounded-2xl p-5 text-white shadow-md border border-blue-900/50 w-full lg:w-auto shrink-0 flex items-center gap-6">
                                <div>
                                    <p class="text-[10px] font-extrabold text-[#9FE7F5] uppercase tracking-widest mb-1">
                                        Status Penilaian</p>
                                    @if ($submission->grade !== null)
                                        <div class="flex items-end gap-1"><span
                                                class="text-3xl font-black">{{ $submission->grade }}</span><span
                                                class="text-sm text-gray-300">/100</span></div>
                                    @elseif($submission->pg_score !== null)
                                        <div class="flex items-end gap-1 text-[#F7AD19]"><span
                                                class="text-3xl font-black">{{ $submission->pg_score }}</span><span
                                                class="text-sm">/100 (PG)</span></div>
                                    @else
                                        <p class="text-sm font-bold text-yellow-300">Menunggu Diperiksa</p>
                                    @endif
                                </div>
                                @if ($submission->feedback)
                                    <div class="hidden md:block w-px h-10 bg-white/20"></div>
                                    <div class="hidden md:block max-w-[200px]">
                                        <p
                                            class="text-[10px] uppercase tracking-widest text-[#F7AD19] font-bold mb-0.5">
                                            Catatan:</p>
                                        <p class="text-xs italic text-gray-200 truncate">"{{ $submission->feedback }}"
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Instruksi Tugas Area Luas -->
                    <div>
                        <h4
                            class="text-sm font-extrabold text-[#053F5C] uppercase tracking-widest mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#F7AD19]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Instruksi Tugas
                        </h4>
                        <div
                            class="ck-content prose prose-base max-w-none text-gray-800 leading-relaxed bg-[#f4f7fa] p-8 rounded-3xl border border-gray-100 shadow-inner">
                            {!! $assignment->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. RUANG KERJA (WORKSPACE) -->
            <div id="workspace-area" x-data="{
                tab: '{{ $assignment->multipleChoices->count() > 0 ? 'pg' : 'essay' }}',
                isFullscreen: false
            }" class="scroll-mt-6">

                <form id="submission-form" action="{{ route('siswa.assignments.submit', $assignment->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden input untuk menampung gabungan Esai + Kode Editor -->
                    <input type="hidden" name="code_snippet" id="final_code_snippet" value="">

                    <div
                        :class="isFullscreen ? 'fixed inset-0 z-[100] bg-[#f4f7fa] flex flex-col p-0 sm:p-4' :
                            'bg-white shadow-sm rounded-3xl border border-gray-100 flex flex-col overflow-hidden transition-all duration-300'">

                        <!-- Header Tabs Workspace -->
                        <div class="bg-gray-50 border-b border-gray-200 p-3 sm:px-6 sm:py-4 flex flex-wrap justify-between items-center gap-3"
                            :class="isFullscreen ? 'rounded-t-2xl' : ''">
                            <div class="flex bg-gray-200/80 p-1.5 rounded-xl overflow-x-auto gap-1">

                                @if ($assignment->multipleChoices->count() > 0)
                                    <button @click="tab = 'pg'" type="button"
                                        :class="tab === 'pg' ? 'bg-white text-[#053F5C] shadow-sm font-black' :
                                            'text-gray-500 hover:text-gray-700 font-bold'"
                                        class="px-5 py-2 text-sm rounded-lg transition-all flex items-center whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2 text-[#F7AD19]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                            </path>
                                        </svg>
                                        Pilihan Ganda
                                    </button>
                                @endif

                                <button @click="tab = 'essay'" type="button"
                                    :class="tab === 'essay' ? 'bg-white text-[#053F5C] shadow-sm font-black' :
                                        'text-gray-500 hover:text-gray-700 font-bold'"
                                    class="px-5 py-2 text-sm rounded-lg transition-all flex items-center whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Teks Esai
                                </button>

                                <button @click="tab = 'code'" type="button"
                                    :class="tab === 'code' ? 'bg-[#053F5C] text-white shadow-sm font-black' :
                                        'text-gray-500 hover:text-gray-700 font-bold'"
                                    class="px-5 py-2 text-sm rounded-lg transition-all flex items-center whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    Code Editor (Python)
                                </button>

                                <button @click="tab = 'file'" type="button"
                                    :class="tab === 'file' ? 'bg-white text-[#053F5C] shadow-sm font-black' :
                                        'text-gray-500 hover:text-gray-700 font-bold'"
                                    class="px-5 py-2 text-sm rounded-lg transition-all flex items-center whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>
                                    Upload File
                                </button>
                            </div>

                            <button type="button" @click="isFullscreen = !isFullscreen"
                                class="text-gray-500 hover:text-[#429EBD] bg-white border border-gray-200 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center shadow-sm shrink-0">
                                <svg x-show="!isFullscreen" class="w-4 h-4 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                    </path>
                                </svg>
                                <svg x-show="isFullscreen" style="display: none;" class="w-4 h-4 mr-2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span x-text="isFullscreen ? 'Keluar Fullscreen' : 'Layar Penuh'"></span>
                            </button>
                        </div>

                        <!-- Konten Workspace -->
                        <div class="bg-white flex-1 flex flex-col overflow-y-auto"
                            :class="isFullscreen ? 'rounded-b-2xl shadow-xl' : 'min-h-[500px]'">

                            <!-- TAB: Pilihan Ganda -->
                            @if ($assignment->multipleChoices->count() > 0)
                                @php $oldAnswers = ($submission && $submission->pg_answers) ? json_decode($submission->pg_answers, true) : []; @endphp
                                <div x-show="tab === 'pg'" class="p-6 md:p-10 space-y-6">
                                    @foreach ($assignment->multipleChoices as $index => $pg)
                                        <div class="bg-[#f4f7fa] p-6 rounded-2xl border border-gray-200">
                                            <div class="flex items-start mb-4">
                                                <span
                                                    class="bg-[#053F5C] text-white text-xs font-black w-6 h-6 rounded-full flex items-center justify-center shrink-0 mr-3 mt-0.5">{{ $index + 1 }}</span>
                                                <p class="font-bold text-[#053F5C] text-base leading-relaxed">
                                                    {{ $pg->question }}</p>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-9">
                                                @foreach (['a' => $pg->option_a, 'b' => $pg->option_b, 'c' => $pg->option_c, 'd' => $pg->option_d] as $optKey => $optValue)
                                                    @php $isChecked = isset($oldAnswers[$pg->id]) &&$oldAnswers[$pg->id] ===$optKey; @endphp
                                                    <label
                                                        class="flex items-center p-4 rounded-xl border {{ $isChecked ? 'border-[#429EBD] bg-blue-50' : 'border-gray-200 bg-white hover:border-[#429EBD]' }} cursor-pointer transition-all">
                                                        <input type="radio" name="pg_answers[{{ $pg->id }}]"
                                                            value="{{ $optKey }}"
                                                            class="text-[#429EBD] focus:ring-[#429EBD] w-4 h-4 border-gray-300"
                                                            {{ $isChecked ? 'checked' : '' }} required>
                                                        <span class="ml-3 text-sm font-semibold text-gray-700"><strong
                                                                class="uppercase mr-2">{{ $optKey }}.</strong>
                                                            {{ $optValue }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- TAB: Esai (CKEditor) -->
                            <div x-show="tab === 'essay'" style="display: none;" class="p-6 md:p-8 flex-1">
                                <label
                                    class="block font-extrabold text-sm text-[#053F5C] mb-3 uppercase tracking-wide">Jawaban
                                    Esai / Teks</label>
                                <!-- Kita ambil kode lama submission (jika bukan format kode python) untuk dimasukkan ke editor -->
                                <textarea id="essay_editor" class="w-full">{{ $submission->code_snippet ?? '' }}</textarea>
                            </div>

                            <!-- TAB: Code Editor (Ace & Skulpt Python) -->
                            <div x-show="tab === 'code'" style="display: none;"
                                class="flex-1 flex flex-col p-4 md:p-6 bg-[#f4f7fa]">
                                <div class="flex flex-col lg:flex-row gap-6 h-full min-h-[400px]">

                                    <!-- Sisi Kiri: Ace Editor -->
                                    <div class="flex-1 flex flex-col">
                                        <div
                                            class="bg-[#1e1e1e] text-gray-300 px-4 py-2 rounded-t-xl text-xs font-mono font-bold flex justify-between items-center border-b border-gray-700">
                                            <span>main.py</span>
                                        </div>
                                        <div
                                            class="flex-1 relative rounded-b-xl overflow-hidden shadow-inner border border-gray-800">
                                            <div id="ace-editor" class="absolute inset-0"># Tulis kode Python Anda di
                                                sini...
                                                print("Halo dari Code Editor!")
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sisi Kanan: Python Runner Console -->
                                    <div class="w-full lg:w-1/3 flex flex-col gap-4">
                                        <button type="button" id="btn-run-code"
                                            class="w-full bg-[#10b981] hover:bg-[#059669] text-white font-black py-3 rounded-xl shadow-lg shadow-green-500/30 flex justify-center items-center gap-2 transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Jalankan Kode
                                        </button>

                                        <div
                                            class="flex-1 bg-black rounded-xl border border-gray-800 flex flex-col overflow-hidden shadow-inner">
                                            <div
                                                class="bg-gray-900 text-gray-400 px-4 py-2 text-xs font-bold border-b border-gray-800 uppercase tracking-widest">
                                                Terminal Output
                                            </div>
                                            <pre id="python-output"
                                                class="flex-1 p-4 text-sm font-mono text-green-400 overflow-auto whitespace-pre-wrap leading-relaxed m-0">Tekan "Jalankan Kode" untuk melihat hasil output.</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: Upload File -->
                            <div x-show="tab === 'file'" style="display: none;"
                                class="p-6 md:p-10 flex flex-col justify-center items-center min-h-[300px]">
                                <div class="w-full max-w-md">
                                    @if ($submission && $submission->file_path)
                                        <div
                                            class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-between">
                                            <div class="flex items-center text-[#053F5C]">
                                                <svg class="w-6 h-6 mr-2 text-[#429EBD]" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span class="font-bold text-sm">File sudah terunggah</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div
                                        class="border-2 border-dashed border-gray-300 hover:border-[#429EBD] rounded-3xl p-10 bg-gray-50 hover:bg-[#f4f7fa] flex flex-col items-center justify-center transition-all relative text-center group cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 group-hover:text-[#429EBD] mb-4 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <input type="file" name="file_upload"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#053F5C] file:text-white hover:file:bg-[#429EBD] transition-colors cursor-pointer text-center">
                                        <p class="text-[10px] text-gray-400 mt-4 font-bold uppercase tracking-widest">
                                            Maks 10MB (PDF, ZIP, DOCX)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Submit -->
                        <div class="bg-white border-t border-gray-100 p-5 md:p-6 flex justify-between items-center shrink-0"
                            :class="isFullscreen ? 'rounded-b-2xl' : ''">
                            <p class="text-xs text-gray-400 font-medium italic hidden md:block">
                                Jawaban Esai dan Kode Anda akan disimpan otomatis saat dikumpulkan.
                            </p>
                            <button type="submit"
                                class="w-full md:w-auto inline-flex justify-center items-center px-10 py-3.5 bg-[#053F5C] rounded-xl font-black text-white tracking-wide hover:bg-[#F7AD19] hover:text-[#053F5C] focus:ring-4 focus:ring-[#9FE7F5] transition-all shadow-lg text-sm uppercase">
                                {{ $submission ? 'Perbarui Jawaban' : 'Kumpulkan Tugas' }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Scripts: CKEditor, Ace Editor, Skulpt Python -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.3/ace.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/skulpt@1.2.0/dist/skulpt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/skulpt@1.2.0/dist/skulpt-stdlib.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1. Inisialisasi CKEditor untuk Esai
            let essayEditor;
            ClassicEditor
                .create(document.querySelector('#essay_editor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote',
                        'undo', 'redo'
                    ]
                })
                .then(editor => {
                    essayEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            // 2. Inisialisasi Ace Editor (Code Editor)
            var codeEditor = ace.edit("ace-editor");
            codeEditor.setTheme("ace/theme/monokai");
            codeEditor.session.setMode("ace/mode/python");
            codeEditor.setOptions({
                fontSize: "14px",
                showPrintMargin: false,
                enableBasicAutocompletion: true,
                enableLiveAutocompletion: true
            });

            // Jika ada kode yang tersimpan sebelumnya
            let savedCode = `{{ $submission->code_snippet ?? '' }}`;
            if (savedCode && savedCode.includes("def ") || savedCode.includes("print(")) {
                codeEditor.setValue(savedCode, 1);
            }

            // 3. Konfigurasi Skulpt (Menjalankan Python)
            function outf(text) {
                var mypre = document.getElementById("python-output");
                mypre.innerHTML = mypre.innerHTML + text;
            }

            function builtinRead(x) {
                if (Sk.builtinFiles === undefined || Sk.builtinFiles["files"][x] === undefined)
                    throw "File not found: '" + x + "'";
                return Sk.builtinFiles["files"][x];
            }

            document.getElementById('btn-run-code').addEventListener('click', function() {
                var prog = codeEditor.getValue();
                var mypre = document.getElementById("python-output");
                mypre.innerHTML = ''; // Bersihkan output sebelumnya
                Sk.pre = "python-output";
                Sk.configure({
                    output: outf,
                    read: builtinRead
                });
                var myPromise = Sk.misceval.asyncToPromise(function() {
                    return Sk.importMainWithBody("<stdin>", false, prog, true);
                });
                myPromise.then(function(mod) {
                        // Berhasil
                    },
                    function(err) {
                        mypre.innerHTML = mypre.innerHTML + '<span class="text-red-500">' + err
                            .toString() + '</span>';
                    });
            });

            // 4. Mencegat (Intercept) Submit Form untuk menggabungkan Jawaban
            document.getElementById('submission-form').addEventListener('submit', function(e) {
                let essayContent = essayEditor ? essayEditor.getData() : '';
                let codeContent = codeEditor.getValue();
                let finalInput = document.getElementById('final_code_snippet');

                // Jika siswa menulis di kedua tab, gabungkan. Jika salah satu, kirim salah satu.
                let combined = "";
                if (essayContent.trim() !== '') {
                    combined += "=== JAWABAN ESAI ===\n" + essayContent + "\n\n";
                }
                if (codeContent.trim() !== '' && codeContent.trim() !==
                    '# Tulis kode Python Anda di sini...\nprint("Halo dari Code Editor!")') {
                    combined += "=== KODE PYTHON ===\n" + codeContent;
                }

                finalInput.value = combined;
            });
        });
    </script>
</x-app-layout>
