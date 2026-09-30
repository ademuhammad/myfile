<x-guest-layout>
    <!-- Welcome Header -->
    <div class="mb-8 text-center md:text-left">
        <h2 class="text-3xl md:text-4xl font-black text-[#053F5C] tracking-tight">Create Account 🚀</h2>
        <p class="text-sm font-medium text-gray-500 mt-2">Join your classroom and start learning today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Full Name -->
        <div>
            <x-input-label for="name" value="Full Name" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <x-text-input id="name"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium placeholder-gray-400"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" value="Username" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <x-text-input id="username"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium placeholder-gray-400"
                type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Choose a username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Classroom Selection -->
        <div>
            <x-input-label for="classroom_id" value="Classroom" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <select name="classroom_id" id="classroom_id"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium cursor-pointer" required>
                <option value="">-- Select Classroom --</option>
                @foreach($classrooms as $kelas)
                    <option value="{{ $kelas->id }}" {{ old('classroom_id') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->name }} ({{ $kelas->academic_year }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('classroom_id')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <x-text-input id="password"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium placeholder-gray-400"
                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <x-text-input id="password_confirmation"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium placeholder-gray-400"
                type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full mt-6 inline-flex justify-center items-center px-6 py-3.5 bg-[#053F5C] hover:bg-[#429EBD] border border-transparent rounded-xl font-bold text-white tracking-wide focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition-all duration-300 shadow-lg shadow-blue-900/20 hover:-translate-y-0.5">
            Sign Up
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <!-- Login Link -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center text-sm text-gray-500 font-medium">
            Already have an account?
            <a href="{{ route('login') }}" class="font-black text-[#F7AD19] hover:text-[#429EBD] transition-colors ml-1 uppercase tracking-wider">Sign In</a>
        </div>
    </form>
</x-guest-layout>
