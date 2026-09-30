<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('guru.users.index') }}" class="text-[#F7AD19] hover:text-[#429EBD] transition-colors p-2 bg-white rounded-lg shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                Daftarkan Siswa Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#053F5C] to-[#429EBD]"></div>

                <form action="{{ route('guru.users.store') }}" method="POST" class="p-6 md:p-10 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Nama Lengkap Siswa</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required autofocus placeholder="Contoh: Budi Santoso">
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="username" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">NIS / Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required autocomplete="username" placeholder="Contoh: 10293847">
                        @error('username') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="classroom_id" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Pilih Kelas</label>
                        <select name="classroom_id" id="classroom_id" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 cursor-pointer" required>
                            <option value="">-- Pilih Kelas Siswa --</option>
                            @foreach($classrooms as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('classroom_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->name }} ({{ $kelas->academic_year }})
                                </option>
                            @endforeach
                        </select>
                        @error('classroom_id') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">Password Default</label>
                        <input type="password" name="password" id="password" class="w-full bg-[#f4f7fa] border-0 focus:ring-2 focus:ring-[#429EBD] rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800" required placeholder="••••••••">
                        <p class="text-xs text-gray-400 mt-2 font-medium">Siswa akan menggunakan password ini untuk login pertama kali.</p>
                        @error('password') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 mt-8">
                        <a href="{{ route('guru.users.index') }}" class="text-gray-500 hover:text-[#053F5C] font-bold mr-6 transition-colors text-sm">Batal</a>
                        <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-[#F7AD19] border border-transparent rounded-xl font-bold text-[#053F5C] tracking-wide hover:bg-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition-all shadow-md shadow-yellow-500/20">
                            Simpan Akun Siswa
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
