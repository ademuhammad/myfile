<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('My Profile') }} <span class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Pengaturan Akun</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Profile Info Card -->
            <div class="bg-white p-6 md:p-10 shadow-sm rounded-3xl border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-[#053F5C] to-[#429EBD]"></div>
                <div class="max-w-xl ml-2 md:ml-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="bg-white p-6 md:p-10 shadow-sm rounded-3xl border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-[#F7AD19] to-yellow-300"></div>
                <div class="max-w-xl ml-2 md:ml-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="bg-white p-6 md:p-10 shadow-sm rounded-3xl border border-red-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-500 to-red-400"></div>
                <div class="max-w-xl ml-2 md:ml-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
