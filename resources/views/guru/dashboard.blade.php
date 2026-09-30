<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Bapak/Ibu {{ Auth::user()->name }}!</h3>
                    <p>Ini adalah halaman panel kontrol Anda. Dari sini Anda bisa mengelola materi dan tugas siswa.</p>

                    <div class="mt-6">
                        <h4 class="font-semibold">Daftar Kelas Anda:</h4>
                        <ul class="list-disc list-inside mt-2">
                            @foreach($classrooms as $kelas)
                                <li>{{ $kelas->name }} ({{ $kelas->academic_year }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
