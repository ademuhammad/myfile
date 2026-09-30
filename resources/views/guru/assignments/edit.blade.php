<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.index') }}" class="text-[#F7AD19] hover:text-[#429EBD] p-2 bg-white rounded-lg border border-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg></a>
            <h2 class="font-extrabold text-2xl text-[#053F5C]">Edit Tugas</h2>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#429EBD]"></div>

                <!-- Load Alpine JS Data dengan format JSON yang sudah diperbaiki spasinya -->
                <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" class="p-6 md:p-10 space-y-8"
                      x-data="{
                          pgQuestions: {{ Js::from($assignment->multipleChoices->map(fn($q) => [
                              'id' => $q->id,
                              'question' => $q->question,
                              'option_a' => $q->option_a,
                              'option_b' => $q->option_b,
                              'option_c' => $q->option_c,
                              'option_d' => $q->option_d,
                              'correct_answer' => $q->correct_answer
                          ])) }},
                          addQuestion() { this.pgQuestions.push({ id: Date.now(), question: '', option_a: '', option_b: '', option_c: '', option_d: '', correct_answer: 'a' }) },
                          removeQuestion(id) { this.pgQuestions = this.pgQuestions.filter(q => q.id !== id) }
                      }">
                    @csrf
                    @method('PUT')

                    <div class="bg-[#f4f7fa] p-6 rounded-2xl border border-gray-100 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Judul Tugas *</label>
                                <input type="text" name="title" value="{{ old('title', $assignment->title) }}" class="w-full bg-white border-gray-200 rounded-xl px-4 py-3" required>
                            </div>
                            <div>
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Pilih Kelas *</label>
                                <select name="classroom_id" class="w-full bg-white border-gray-200 rounded-xl px-4 py-3" required>
                                    <!-- PERBAIKAN: Spasi pada foreach -->
                                    <?php foreach($classrooms as$kelas): ?>
                                        <option value="<?php echo $kelas->id; ?>" <?php echo $assignment->classroom_id ==$kelas->id ? 'selected' : ''; ?>>
                                            <?php echo $kelas->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Batas Waktu (Deadline) *</label>
                                <input type="datetime-local" name="due_date" value="{{ \Carbon\Carbon::parse(old('due_date', $assignment->due_date))->format('Y-m-d\TH:i') }}" class="w-full bg-white border-gray-200 rounded-xl px-4 py-3" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Instruksi *</label>
                                <textarea name="description" rows="3" class="w-full bg-white border-gray-200 rounded-xl px-4 py-3" required>{{ old('description', $assignment->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Builder Soal PG Edit -->
                    <div>
                        <div class="flex justify-between items-center mb-4 border-t pt-6">
                            <h3 class="font-black text-[#053F5C] text-lg">Daftar Soal Pilihan Ganda</h3>
                            <span class="text-xs font-bold bg-blue-50 text-[#429EBD] px-3 py-1 rounded-lg" x-text="pgQuestions.length + ' Soal'"></span>
                        </div>
                        <div class="space-y-6">
                            <template x-for="(q, index) in pgQuestions" :key="q.id">
                                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative">
                                    <button type="button" x-on:click="removeQuestion(q.id)" class="absolute top-4 right-4 text-red-400 bg-red-50 p-2 rounded-lg font-bold">X</button>
                                    <h4 class="font-black text-sm text-[#053F5C] mb-4" x-text="`Soal #${index + 1}`"></h4>

                                    <div class="space-y-4">
                                        <textarea :name="`pg_questions[${index}][question]`" x-model="q.question" rows="2" class="w-full bg-[#f4f7fa] border-0 rounded-xl px-4 py-3 text-sm font-semibold" placeholder="Pertanyaan..." required></textarea>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                            <input type="text" :name="`pg_questions[${index}][option_a]`" x-model="q.option_a" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" placeholder="Opsi A" required>
                                            <input type="text" :name="`pg_questions[${index}][option_b]`" x-model="q.option_b" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" placeholder="Opsi B" required>
                                            <input type="text" :name="`pg_questions[${index}][option_c]`" x-model="q.option_c" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" placeholder="Opsi C" required>
                                            <input type="text" :name="`pg_questions[${index}][option_d]`" x-model="q.option_d" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2" placeholder="Opsi D" required>
                                        </div>

                                        <div>
                                            <label class="block font-bold text-xs text-gray-500 mb-2 uppercase">Kunci Jawaban Benar</label>
                                            <div class="flex gap-4">
                                                <template x-for="opt in ['a','b','c','d']">
                                                    <label class="flex items-center cursor-pointer">
                                                        <input type="radio" :name="`pg_questions[${index}][correct_answer]`" :value="opt" x-model="q.correct_answer" class="text-[#429EBD]">
                                                        <span class="ml-2 font-bold text-[#053F5C] uppercase" x-text="opt"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <button type="button" x-on:click="addQuestion()" class="mt-5 w-full border-2 border-dashed border-[#429EBD] font-bold py-4 rounded-xl flex justify-center items-center text-[#429EBD]">
                            + Tambah Soal Pilihan Ganda
                        </button>
                    </div>

                    <div class="flex justify-end border-t pt-6">
                        <button type="submit" class="px-8 py-3.5 bg-[#429EBD] rounded-xl font-bold text-white hover:bg-[#053F5C] transition-all">Perbarui Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
