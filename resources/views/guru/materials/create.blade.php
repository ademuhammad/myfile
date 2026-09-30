<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('materials.index') }}" class="text-[#F7AD19] hover:text-[#429EBD] transition-colors p-2 bg-white rounded-lg shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                Tambah Materi Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#053F5C] to-[#429EBD]"></div>

                <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-10 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Topik / Bab Materi -->
                        <div class="md:col-span-1">
                            <label for="topic" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Topik / Sub Materi</label>
                            <input type="text" name="topic" id="topic" value="{{ old('topic') }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required autofocus placeholder="Contoh: Bab 1: Pemrograman Dasar">
                            @error('topic') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Judul Materi -->
                        <div class="md:col-span-1">
                            <label for="title" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Judul Rincian Materi</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required placeholder="Contoh: Pengenalan Algoritma">
                            @error('title') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pilih Banyak Kelas (Checkboxes) -->
                        <div class="md:col-span-2">
                            <label class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Pilih Kelas (Bisa Lebih Dari Satu)</label>
                            <div class="bg-[#f4f7fa] rounded-xl p-5 border border-gray-100">
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($classrooms as $kelas)
                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                            <input type="checkbox" name="classroom_ids[]" value="{{ $kelas->id }}"
                                                class="w-5 h-5 rounded border-gray-300 text-[#429EBD] shadow-sm focus:ring-[#429EBD] transition-colors"
                                                {{ (is_array(old('classroom_ids')) && in_array($kelas->id, old('classroom_ids'))) ? 'checked' : '' }}>
                                            <span class="text-sm font-bold text-gray-600 group-hover:text-[#053F5C] transition-colors">{{ $kelas->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 font-medium">*Kosongkan semua centang jika materi ini untuk semua kelas umum.</p>
                            @error('classroom_ids') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Isi/Konten Materi -->
                    <div>
                        <label for="content" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Isi Materi / Deskripsi</label>
                        <textarea name="content" id="content" rows="6" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 leading-relaxed" required placeholder="Ketikkan penjelasan materi di sini...">{{ old('content') }}</textarea>
                        @error('content') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Upload Lampiran -->
                    <div>
                        <label for="attachment" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Upload Lampiran (Opsional)</label>
                        <div class="border-2 border-dashed border-gray-300 hover:border-[#429EBD] rounded-2xl p-6 bg-gray-50 flex flex-col items-center justify-center transition-colors relative">
                            <input type="file" name="attachment" id="attachment" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-[#053F5C] file:text-white hover:file:bg-[#429EBD] transition-colors cursor-pointer text-center">
                        </div>
                        @error('attachment') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 mt-8">
                        <a href="{{ route('materials.index') }}" class="text-gray-500 hover:text-[#053F5C] font-bold mr-6 transition-colors text-sm">Batal</a>
                        <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-[#F7AD19] border border-transparent rounded-xl font-bold text-[#053F5C] tracking-wide hover:bg-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition-all shadow-md shadow-yellow-500/20">
                            Simpan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
