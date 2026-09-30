<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
            {{ __('Assignments & Tasks') }} <span class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Daftar Tugas</span>
        </h2>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(!$user->classroom_id)
                <!-- Empty State: Belum ada kelas -->
                <div class="bg-yellow-50 border-l-4 border-[#F7AD19] p-6 rounded-r-2xl shadow-sm flex items-start space-x-4">
                    <svg class="w-6 h-6 text-[#F7AD19] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h3 class="text-[#053F5C] font-bold text-lg">No Classroom Assigned</h3>
                        <p class="text-gray-600 text-sm mt-1">You have not been assigned to any classroom yet. Please contact your teacher or administrator.</p>
                    </div>
                </div>
            @elseif($assignments->isEmpty())
                <!-- Empty State: Belum ada tugas -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-[#f4f7fe] rounded-full flex items-center justify-center mb-5 border border-blue-50">
                        <svg class="w-10 h-10 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#053F5C]">You're All Caught Up!</h3>
                    <p class="text-gray-500 mt-2 max-w-md font-medium">There are no assignments posted for your class right now. Enjoy your free time!</p>
                </div>
            @else
                <!-- Daftar Kartu Tugas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($assignments as $tugas)
                        @php
                            $isOverdue = $tugas->due_date->isPast();
                        @endphp

                        <div class="bg-white rounded-2xl p-6 shadow-sm border {{ $isOverdue ? 'border-red-200 shadow-red-900/5' : 'border-gray-100 shadow-blue-900/5' }} hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group flex flex-col h-full">

                            <!-- Aksen garis atas melayang -->
                            <div class="absolute top-0 left-0 w-full h-1.5 {{ $isOverdue ? 'bg-red-500' : 'bg-[#F7AD19] group-hover:bg-[#429EBD]' }} transition-colors duration-300"></div>

                            <div class="flex-1 mt-2">
                                <!-- Judul & Badge Status -->
                                <div class="flex justify-between items-start mb-3 gap-2">
                                    <h4 class="font-extrabold text-xl text-[#053F5C] group-hover:text-[#429EBD] transition-colors leading-tight">{{ $tugas->title }}</h4>

                                    @if($isOverdue)
                                        <span class="bg-red-100 text-red-600 text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest shrink-0">Overdue</span>
                                    @else
                                        <span class="bg-blue-50 text-[#429EBD] text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest shrink-0">Active</span>
                                    @endif
                                </div>

                                <!-- Info Guru -->
                                <div class="flex items-center text-xs text-gray-500 mb-5 font-medium">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $tugas->teacher->name ?? 'Teacher' }}
                                </div>

                                <!-- Tenggat Waktu (Due Date Box) -->
                                <div class="flex items-center text-sm font-bold {{ $isOverdue ? 'text-red-600 bg-red-50 border-red-100' : 'text-[#053F5C] bg-[#f4f7fe] border-blue-50' }} p-3.5 rounded-xl border mb-2">
                                    <svg class="w-5 h-5 mr-3 shrink-0 {{ $isOverdue ? 'text-red-500' : 'text-[#429EBD]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <div>
                                        <span class="block text-[10px] uppercase tracking-widest text-gray-400 font-extrabold leading-none mb-1">Due Date</span>
                                        {{ $tugas->due_date->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi (Sticky di bawah kartu) -->
                            <div class="mt-6 pt-5 border-t border-gray-100">
                                <a href="{{ route('siswa.assignments.show', $tugas->id) }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#053F5C] text-white rounded-xl font-bold text-sm hover:bg-[#429EBD] focus:ring-4 focus:ring-[#9FE7F5] transition-all shadow-md shadow-blue-900/10 group-hover:bg-[#429EBD]">
                                    Open & Submit Task
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
