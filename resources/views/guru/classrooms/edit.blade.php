<x-app-layout>
    <x-slot name="header">
        Edit Data Kelas
    </x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('guru.classrooms.update', $classroom->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block font-bold text-sm text-[#053F5C] mb-2">Nama Kelas</label>
                <input type="text" name="name" id="name" value="{{ old('name', $classroom->name) }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3 text-sm transition-all" required autofocus>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-8">
                <label for="academic_year" class="block font-bold text-sm text-[#053F5C] mb-2">Tahun Ajaran</label>
                <input type="text" name="academic_year" id="academic_year" value="{{ old('academic_year', $classroom->academic_year) }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3 text-sm transition-all" required>
                @error('academic_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end border-t border-gray-100 pt-5">
                <a href="{{ route('guru.classrooms.index') }}" class="text-gray-500 hover:text-gray-800 font-medium mr-5 transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-[#F7AD19] hover:bg-yellow-400 border border-transparent rounded-xl font-bold text-[#053F5C] focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition ease-in-out duration-200 shadow-lg shadow-yellow-500/30">
                    Perbarui Kelas
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
