<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-[#053F5C] leading-tight tracking-tight">
                {{ __('Student Submissions / Penilaian Tugas') }}
            </h2>
            <a href="{{ route('assignments.index') }}" class="text-[#F7AD19] hover:text-[#429EBD] font-bold text-sm flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Assignments
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start" role="alert">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Success!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Info Tugas -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 relative">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-[#429EBD]"></div>
                <div class="p-6 md:p-8">
                    <h3 class="text-2xl font-extrabold text-[#053F5C] mb-4">{{ $assignment->title }}</h3>

                    <div class="flex flex-wrap items-center gap-3 text-sm mb-6 border-b border-gray-100 pb-6">
                        <span class="inline-flex items-center bg-[#f4f7fe] text-[#053F5C] px-3 py-1.5 rounded-lg font-medium border border-blue-50">
                            <svg class="w-4 h-4 mr-1.5 text-[#429EBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Class: <strong class="ml-1">{{ $assignment->classroom->name ?? 'All Classes' }}</strong>
                        </span>

                        @php $isOverdue = $assignment->due_date->isPast(); @endphp
                        <span class="inline-flex items-center {{ $isOverdue ? 'bg-red-50 text-red-700 border-red-100' : 'bg-yellow-50 text-yellow-800 border-yellow-100' }} px-3 py-1.5 rounded-lg font-medium border">
                            <svg class="w-4 h-4 mr-1.5 {{ $isOverdue ? 'text-red-500' : 'text-[#F7AD19]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Due: <strong class="ml-1">{{ $assignment->due_date->format('d M Y, H:i') }}</strong>
                        </span>
                    </div>

                    <div class="prose max-w-none text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $assignment->description }}</div>
                </div>
            </div>

            <!-- Tabel Pengumpulan & Riwayat Siswa -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 md:p-8 overflow-x-auto">
                    <h4 class="text-lg font-extrabold text-[#053F5C] mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#F7AD19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Student Submissions ({{ $submissions->count() }})
                    </h4>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-[#429EBD]">
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Details</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Current Submission</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-1/3">Grading Form</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($submissions as $submission)
                                <tr class="hover:bg-[#f4f7fa] transition-colors">
                                    <!-- Detail Siswa -->
                                    <td class="p-4 align-top border-r border-gray-50">
                                        <div class="font-extrabold text-[#053F5C] text-base">{{ $submission->student->name }}</div>
                                        <div class="text-xs font-bold text-[#429EBD] tracking-wider mt-0.5">ID: {{ $submission->student->username }}</div>

                                        <!-- Status Keterlambatan -->
                                        <div class="mt-3 text-xs font-medium text-gray-500 flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $submission->updated_at->format('d M Y, H:i') }}
                                        </div>
                                        @if($submission->updated_at > $assignment->due_date)
                                            <span class="inline-block mt-1 bg-red-100 text-red-600 text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-widest">Late / Terlambat</span>
                                        @endif

                                        <!-- TOMBOL LIHAT HISTORY -->
                                        <div class="mt-4">
                                            <a href="{{ route('guru.assignments.history', ['assignment' => $assignment->id, 'submission' => $submission->id]) }}" class="inline-flex items-center text-[10px] font-extrabold text-[#F7AD19] bg-yellow-50 px-3 py-1.5 rounded-lg border border-yellow-100 hover:bg-[#F7AD19] hover:text-[#053F5C] uppercase tracking-widest transition-all">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                View Full History
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Lampiran File / Kode Terkini -->
                                    <td class="p-4 align-top">
                                        <!-- File Aktif -->
                                        @if($submission->file_path)
                                            <a href="{{ route('assignments.submission.download', $submission->id) }}" class="inline-flex items-center bg-[#053F5C] text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#429EBD] transition-all shadow-sm mb-3">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download Attached File
                                            </a>
                                        @endif

                                        <!-- Kode Aktif -->
                                        @if($submission->code_snippet)
                                            <div class="mb-2">
                                                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Latest Code Snippet:</span>
                                                <textarea readonly rows="4" class="w-full text-xs font-mono bg-[#1e1e1e] text-green-400 p-3 rounded-xl mt-1 border-0 focus:ring-0 leading-relaxed">{{ $submission->code_snippet }}</textarea>
                                            </div>
                                        @endif

                                        @if(!$submission->file_path && !$submission->code_snippet)
                                            <span class="inline-block bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-medium italic">No content submitted.</span>
                                        @endif
                                    </td>

                                    <!-- Form Penilaian -->
                                    <td class="p-4 align-top bg-blue-50/30 rounded-r-xl border-l border-gray-50">
                                        <form action="{{ route('assignments.grade', $submission->id) }}" method="POST" class="flex flex-col space-y-3">
                                            @csrf
                                            <div>
                                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-widest mb-1">Score / Nilai (0-100)</label>
                                                <input type="number" name="grade" value="{{ $submission->grade }}" min="0" max="100" class="w-full bg-white border-gray-200 rounded-xl px-3 py-2 text-sm font-bold focus:border-[#429EBD] focus:ring-[#9FE7F5] text-[#053F5C]" placeholder="0" required>
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-widest mb-1">Feedback / Catatan</label>
                                                <textarea name="feedback" rows="2" class="w-full bg-white border-gray-200 rounded-xl px-3 py-2 text-sm focus:border-[#429EBD] focus:ring-[#9FE7F5]" placeholder="Add comments here...">{{ $submission->feedback }}</textarea>
                                            </div>

                                            <button type="submit" class="w-full bg-[#F7AD19] text-[#053F5C] font-bold py-2.5 px-4 rounded-xl text-xs uppercase tracking-wide hover:bg-yellow-400 shadow-md shadow-yellow-500/20 transition-all focus:ring-4 focus:ring-yellow-200">
                                                Save Grade
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-12 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-3">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">No students have submitted this assignment yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
