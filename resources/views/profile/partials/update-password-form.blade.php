<section>
    <header>
        <h2 class="text-xl font-black text-[#053F5C]">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 font-medium">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium" autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs font-medium" />
        </div>

        <div>
            <label for="update_password_password" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs font-medium" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs font-medium" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#F7AD19] hover:bg-yellow-400 border border-transparent rounded-xl font-bold text-[#053F5C] tracking-wide focus:outline-none focus:ring-4 focus:ring-yellow-200 transition-all duration-300 shadow-md shadow-yellow-500/20 hover:-translate-y-0.5">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-green-600 bg-green-50 px-3 py-2 rounded-lg border border-green-100">
                    &#10003; {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
