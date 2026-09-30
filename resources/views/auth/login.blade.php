<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Welcome Header -->
    <div class="mb-8 text-center md:text-left">
        <h2 class="text-3xl md:text-4xl font-black text-[#053F5C] tracking-tight">Welcome Back! 👋</h2>
        <p class="text-sm font-medium text-gray-500 mt-2">Please sign in to access your dashboard.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" value="Username" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <x-text-input id="username"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium placeholder-gray-400"
                type="text" name="username" :value="old('username')" required autofocus
                placeholder="Enter your username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" class="text-[#053F5C] font-extrabold mb-1.5 text-xs uppercase tracking-wide" />
            <x-text-input id="password"
                class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium placeholder-gray-400"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-medium" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-[#429EBD] shadow-sm focus:ring-[#429EBD] transition-colors"
                    name="remember">
                <span class="ms-2 text-sm text-gray-500 font-semibold group-hover:text-[#053F5C] transition-colors">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-[#429EBD] hover:text-[#053F5C] transition-colors" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full mt-6 inline-flex justify-center items-center px-6 py-3.5 bg-[#053F5C] hover:bg-[#429EBD] border border-transparent rounded-xl font-bold text-white tracking-wide focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition-all duration-300 shadow-lg shadow-blue-900/20 hover:-translate-y-0.5">
            Sign In
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="mt-8 pt-6 border-t border-gray-100 text-center text-sm text-gray-500 font-medium">
                Don't have an account?
                <a href="{{ route('register') }}"
                    class="font-black text-[#F7AD19] hover:text-[#429EBD] transition-colors ml-1 uppercase tracking-wider">Create One</a>
            </div>
        @endif
    </form>
</x-guest-layout>
