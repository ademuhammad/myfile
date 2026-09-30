<section>
    <header>
        <h2 class="text-xl font-black text-[#053F5C]">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 font-medium">
            {{ __("Update your account's profile name and username (NIS).") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">{{ __('Full Name') }}</label>
            <input id="name" name="name" type="text" class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-xs font-medium" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="username" class="block font-extrabold text-sm text-[#053F5C] mb-2 uppercase tracking-wide">{{ __('Username / NIS') }}</label>
            <input id="username" name="username" type="text" class="block w-full bg-[#f4f7fa] border border-gray-100 focus:bg-white focus:border-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5]/50 rounded-xl px-4 py-3.5 text-sm transition-all text-gray-800 font-medium" value="{{ old('username', $user->username) }}" required autocomplete="username" />
            <x-input-error class="mt-2 text-xs font-medium" :messages="$errors->get('username')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#053F5C] hover:bg-[#429EBD] border border-transparent rounded-xl font-bold text-white tracking-wide focus:outline-none focus:ring-4 focus:ring-[#9FE7F5] transition-all duration-300 shadow-md shadow-blue-900/10 hover:-translate-y-0.5">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-green-600 bg-green-50 px-3 py-2 rounded-lg border border-green-100">
                    &#10003; {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
