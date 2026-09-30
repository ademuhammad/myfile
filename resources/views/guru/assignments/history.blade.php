<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Revision History') }} <span class="text-[#429EBD] font-medium text-lg ml-2 hidden sm:inline-block">| Riwayat Perubahan</span>
            </h2>
            <a href="{{ route('assignments.show', $assignment->id) }}" class="text-[#F7AD19] hover:text-[#429EBD] font-bold text-sm flex items-center transition-colors bg-yellow-50 hover:bg-blue-50 px-4 py-2 rounded-xl">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Grading
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Identitas Siswa & Tugas -->
            <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-3xl border border-gray-100 relative">
                <!-- Aksen Garis Gradasi Kiri -->
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-[#053F5C] to-[#429EBD]"></div>

                <div class="p-6 md:p-8 ml-2 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-center gap-5">
                        <!-- Avatar Inisial Siswa -->
                        <div class="w-16 h-16 rounded-full bg-[#f4f7fe] border-2 border-[#9FE7F5] flex items-center justify-center text-xl font-black text-[#053F5C] shrink-0">
                            {{ substr($submission->student->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Student Profile</h3>
                            <h2 class="text-2xl font-black text-[#053F5C] leading-none">{{ $submission->student->name }}</h2>
                            <div class="flex items-center mt-2">
                                <span class="bg-blue-50 text-[#429EBD] text-xs font-bold px-2.5 py-1 rounded-md">ID: {{ $submission->student->username }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:text-right w-full md:w-auto border-t md:border-t-0 border-gray-100 pt-4 md:pt-0">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Assignment Details</h3>
                        <h4 class="text-lg font-bold text-gray-800 leading-tight">{{ $assignment->title }}</h4>
                        <div class="mt-2 inline-flex items-center bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600">
                            Current Grade:
                            <strong class="ml-1.5 {{ $submission->grade ? 'text-[#053F5C] text-sm' : 'text-[#F7AD19]' }}">
                                {{ $submission->grade ?? 'Not Graded Yet' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Riwayat -->
            <div class="bg-white shadow-lg shadow-blue-900/5 rounded-3xl border border-gray-100 p-6 md:p-10">
                <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-8">
                    <h4 class="text-xl font-extrabold text-[#053F5C] flex items-center">
                        <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        Submission Timeline
                    </h4>
                    <span class="bg-[#f4f7fe] text-[#053F5C] text-xs font-bold px-3 py-1.5 rounded-xl border border-blue-50">
                        {{ $submission->histories->count() }} Revisions Found
                    </span>
                </div>

                @if($submission->histories->count() > 0)
                    <div class="relative border-l-2 border-dashed border-[#9FE7F5] ml-5 md:ml-8 space-y-12 pb-6">
                        @foreach($submission->histories as $index => $history)
                            <div class="relative pl-8 md:pl-12 group">
                                <!-- Titik Timeline -->
                                <div class="absolute -left-[11px] top-1.5 w-5 h-5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-[#F7AD19] border-4 border-white shadow-[0_0_0_4px_rgba(247,173,25,0.2)]' : 'bg-gray-300 border-4 border-white group-hover:bg-[#429EBD]' }}"></div>

                                <!-- Header Waktu -->
                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                    <span class="text-base font-extrabold text-[#053F5C]">{{ $history->created_at->format('d F Y, H:i') }}</span>
                                    <span class="text-xs text-gray-400 font-medium">({{ $history->created_at->diffForHumans() }})</span>

                                    @if($index === 0)
                                        <span class="bg-[#429EBD] text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm">Latest Version</span>
                                    @endif
                                </div>

                                <!-- Box Konten Riwayat -->
                                <div class="bg-white border {{ $index === 0 ? 'border-[#429EBD] shadow-md shadow-blue-900/5' : 'border-gray-200' }} rounded-2xl p-5 transition-all hover:border-[#429EBD]">

                                    <!-- Tombol Download (Bila Ada File) -->
                                    @if($history->file_path)
                                        <div class="mb-4">
                                            <a href="{{ route('assignments.history.download', $history->id) }}" class="inline-flex items-center px-4 py-2.5 bg-[#053F5C] hover:bg-[#429EBD] text-white rounded-xl text-sm font-bold w-full sm:w-auto transition-colors shadow-md shadow-blue-900/20">
                                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 border border-white/20">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                </div>
                                                Download Revision File
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Kode / Teks -->
                                    @if($history->code_snippet)
                                        <div class="mt-2">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest">Text / Code Snippet:</span>
                                            </div>
                                            <!-- Desain Code Editor yang konsisten -->
                                            <div class="relative rounded-xl overflow-hidden shadow-inner border border-gray-200">
                                                <div class="bg-gray-800 px-4 py-2 flex items-center border-b border-gray-700">
                                                    <div class="flex space-x-2">
                                                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                                    </div>
                                                    <span class="ml-4 text-[10px] font-mono text-gray-400">revision_{{ $index + 1 }}.txt</span>
                                                </div>
                                                <textarea readonly rows="6" class="w-full text-xs font-mono bg-[#1e1e1e] text-green-400 p-4 border-0 focus:ring-0 leading-relaxed resize-none">{{ $history->code_snippet }}</textarea>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!$history->file_path && !$history->code_snippet)
                                        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-6 text-center">
                                            <p class="text-sm text-gray-500 font-medium italic">Empty submission payload recorded.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-700">No Revisions Yet</h4>
                        <p class="text-gray-500 text-sm mt-1">This student has not made any changes to their submission.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
