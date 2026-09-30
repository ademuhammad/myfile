<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.index') }}" class="text-[#F7AD19] hover:text-[#429EBD] p-2 bg-white rounded-lg shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight">Buat Tugas Baru</h2>
        </div>
    </x-slot>

    <!-- CSS Tambahan untuk merapikan desain CKEditor agar sesuai dengan Tailwind -->
    <style>
        .ck-editor__editable_inline { min-height: 200px; border-bottom-left-radius: 0.75rem !important; border-bottom-right-radius: 0.75rem !important; font-size: 0.875rem; }
        .ck-toolbar { border-top-left-radius: 0.75rem !important; border-top-right-radius: 0.75rem !important; background-color: #f4f7fa !important; border-color: #e5e7eb !important; }
    </style>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#F7AD19]"></div>

                <form action="{{ route('assignments.store') }}" method="POST" class="p-6 md:p-10 space-y-8"
                    x-data="{
                        pgQuestions: [],
                        addQuestion() { this.pgQuestions.push({ id: Date.now(), question: '', option_a: '', option_b: '', option_c: '', option_d: '', correct_answer: 'a' }) },
                        removeQuestion(id) { this.pgQuestions = this.pgQuestions.filter(q => q.id !== id) }
                    }">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <!-- Detail Utama -->
                    <div class="bg-[#f4f7fa] p-6 rounded-2xl border border-gray-100 space-y-6">
                        <h3 class="font-black text-[#053F5C] text-lg flex items-center border-b border-gray-200 pb-3">Informasi Utama Tugas</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Judul Tugas *</label>
                                <input type="text" name="title" class="w-full bg-white border-gray-200 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3" placeholder="Contoh: Kuis 1 Dasar Algoritma" required>
                            </div>

                            <div>
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Pilih Kelas *</label>
                                <select name="classroom_id" class="w-full bg-white border-gray-200 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach($classrooms as$kelas): ?>
                                        <option value="<?php echo $kelas->id; ?>">
                                            <?php echo $kelas->name; ?> (<?php echo$kelas->academic_year; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Batas Waktu (Deadline) *</label>
                                <input type="datetime-local" name="due_date" class="w-full bg-white border-gray-200 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3" required>
                            </div>

                            <div class="md:col-span-2 text-gray-800">
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Instruksi *</label>
                                <!-- Tambahkan ID "editor" di sini -->
                                <textarea name="description" id="editor" class="w-full bg-white border-gray-200 rounded-xl px-4 py-3" placeholder="Ketik instruksi di sini..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Builder Soal Pilihan Ganda -->
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-black text-[#053F5C] text-lg flex items-center">Builder Soal Pilihan Ganda</h3>
                            <span class="text-xs font-bold bg-blue-50 text-[#429EBD] px-3 py-1 rounded-lg" x-text="pgQuestions.length + ' Soal'"></span>
                        </div>

                        <div class="space-y-6">
                            <template x-for="(q, index) in pgQuestions" :key="q.id">
                                <div class="bg-white p-6 rounded-2xl border border-[#9FE7F5]/50 shadow-sm relative group">
                                    <div class="absolute top-4 right-4">
                                        <button type="button" x-on:click="removeQuestion(q.id)" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 px-4 rounded-lg font-bold">X</button>
                                    </div>
                                    <h4 class="font-black text-sm text-[#053F5C] mb-4" x-text="`Soal #${index + 1}`"></h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block font-bold text-xs text-gray-500 mb-1">Pertanyaan</label>
                                            <textarea :name="`pg_questions[${index}][question]`" x-model="q.question" rows="2" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3 text-sm font-semibold" placeholder="Tulis pertanyaan di sini..." required></textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                            <div>
                                                <label class="block font-bold text-xs text-gray-500 mb-1">Pilihan A</label>
                                                <input type="text" :name="`pg_questions[${index}][option_a]`" x-model="q.option_a" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" required>
                                            </div>
                                            <div>
                                                <label class="block font-bold text-xs text-gray-500 mb-1">Pilihan B</label>
                                                <input type="text" :name="`pg_questions[${index}][option_b]`" x-model="q.option_b" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" required>
                                            </div>
                                            <div>
                                                <label class="block font-bold text-xs text-gray-500 mb-1">Pilihan C</label>
                                                <input type="text" :name="`pg_questions[${index}][option_c]`" x-model="q.option_c" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" required>
                                            </div>
                                            <div>
                                                <label class="block font-bold text-xs text-gray-500 mb-1">Pilihan D</label>
                                                <input type="text" :name="`pg_questions[${index}][option_d]`" x-model="q.option_d" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" required>
                                            </div>
                                        </div>
                                        <div class="pt-2">
                                            <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-widest">Kunci Jawaban Benar</label>
                                            <div class="flex gap-4">
                                                <template x-for="opt in ['a','b','c','d']">
                                                    <label class="flex items-center cursor-pointer bg-[#f4f7fa] px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                                                        <input type="radio" :name="`pg_questions[${index}][correct_answer]`" :value="opt" x-model="q.correct_answer" class="text-[#429EBD]" required>
                                                        <span class="ml-2 font-bold text-[#053F5C] uppercase" x-text="opt"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <button type="button" x-on:click="addQuestion()" class="mt-5 w-full border-2 border-dashed border-[#429EBD] text-[#053F5C] bg-[#f4f7fa] hover:bg-[#9FE7F5]/30 font-bold py-4 rounded-xl transition-all flex justify-center items-center">
                            + Tambah Soal Pilihan Ganda
                        </button>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 mt-8">
                        <button type="submit" class="px-8 py-3.5 bg-[#053F5C] rounded-xl font-bold text-white hover:bg-[#429EBD] transition-all shadow-md">
                            Simpan Seluruh Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</x-app-layout>
