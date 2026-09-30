<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('guru.users.index') }}" class="text-[#F7AD19] hover:text-[#429EBD] transition-colors p-2 bg-white rounded-lg shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                Edit Data Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#053F5C] to-[#429EBD]"></div>

                <form action="{{ route('guru.users.update', $user->id) }}" method="POST" class="p-6 md:p-10 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Nama Lengkap Siswa</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required autofocus>
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="username" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">NIS / Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required autocomplete="username">
                        @error('username') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="classroom_id" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Pilih Kelas</label>
                        <select name="classroom_id" id="classroom_id" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 cursor-pointer" required>
                            <option value="">-- Pilih Kelas Siswa --</option>
                            @foreach($classrooms as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('classroom_id', $user->classroom_id) == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->name }} ({{ $kelas->academic_year }})
                                </option>
                            @endforeach
                        </select>
                        @error('classroom_id') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Reset Password Baru (Opsional)</label>
                        <input type="password" name="password" id="password" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" placeholder="••••••••">
                        <p class="text-xs text-gray-400 mt-2 font-medium">*Kosongkan bidang ini jika Anda tidak ingin mereset password siswa.</p>
                        @error('password') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 mt-8">
                        <a href="{{ route('guru.users.index') }}" class="text-gray-500 hover:text-[#053F5C] font-bold mr-6 transition-colors text-sm">Batal</a>
                        <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-[#429EBD] border border-transparent rounded-xl font-bold text-white tracking-wide hover:bg-[#053F5C] focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition-all shadow-md shadow-blue-900/20">
                            Perbarui Data Siswa
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
