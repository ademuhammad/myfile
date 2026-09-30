<x-app-layout>
    <x-slot name="header">
        Tambah Kelas Baru
    </x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('guru.classrooms.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="name" class="block font-bold text-sm text-[#053F5C] mb-2">Nama Kelas (Contoh: X RPL 1)</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3 text-sm transition-all" required autofocus placeholder="Masukkan Nama Kelas">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-8">
                <label for="academic_year" class="block font-bold text-sm text-[#053F5C] mb-2">Tahun Ajaran (Contoh: 2026/2027)</label>
                <input type="text" name="academic_year" id="academic_year" value="{{ old('academic_year') }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3 text-sm transition-all" required placeholder="Masukkan Tahun Ajaran">
                @error('academic_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end border-t border-gray-100 pt-5">
                <a href="{{ route('guru.classrooms.index') }}" class="text-gray-500 hover:text-gray-800 font-medium mr-5 transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-[#053F5C] hover:bg-[#429EBD] border border-transparent rounded-xl font-bold text-white focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition ease-in-out duration-200 shadow-lg shadow-blue-900/20">
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
