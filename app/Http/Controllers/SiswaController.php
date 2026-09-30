<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\SubmissionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('classroom');
        $totalMaterials = 0;
        $totalAssignments = 0;
        $completedAssignments = 0;

        if ($user->classroom_id) {
            $totalMaterials = \App\Models\Material::whereHas('classrooms', function ($q) use ($user) {
                $q->where('classrooms.id', $user->classroom_id);
            })->orWhereDoesntHave('classrooms')->count();

            $totalAssignments = \App\Models\Assignment::where('classroom_id', $user->classroom_id)->count();
            $completedAssignments = \App\Models\Submission::where('user_id', $user->id)->count();
        }

        $pendingAssignments = max(0, $totalAssignments - $completedAssignments);

        return view('siswa.dashboard', compact(
            'user',
            'totalMaterials',
            'totalAssignments',
            'completedAssignments',
            'pendingAssignments'
        ));
    }

    public function materials()
    {
        $user = Auth::user()->load('classroom');

        if (!$user->classroom_id) {
            $materials = collect();
            return view('siswa.materials.index', compact('materials', 'user'));
        }

        $materials = \App\Models\Material::with(['teacher'])
            ->whereHas('classrooms', function ($query) use ($user) {
                $query->where('classrooms.id', $user->classroom_id);
            })
            ->orWhereDoesntHave('classrooms')
            ->latest()
            ->paginate(9);

        return view('siswa.materials.index', compact('materials', 'user'));
    }

    public function assignments()
    {
        $user = Auth::user()->load('classroom');
        $assignments = collect();
        if ($user->classroom_id) {
            $assignments = Assignment::with('teacher')->where('classroom_id', $user->classroom_id)->latest()->get();
        }
        return view('siswa.assignments.index', compact('assignments', 'user'));
    }

    public function showAssignment(Assignment $assignment)
    {
        $user = Auth::user();

        if ($assignment->classroom_id !== $user->classroom_id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Muat riwayat dan load Pilihan Ganda dari relasi Tugas (Assignment)
        $assignment->load('multipleChoices');

        $submission = Submission::with('histories')
            ->where('assignment_id', $assignment->id)
            ->where('user_id', $user->id)
            ->first();

        return view('siswa.assignments.show', compact('assignment', 'submission'));
    }

    // INI ADALAH FUNGSI UTAMA UNTUK MENYIMPAN TUGAS (Termasuk PG)
    public function submit(Request $request, $id)
    {
        $assignment = \App\Models\Assignment::with('multipleChoices')->findOrFail($id);

        $request->validate([
            'code_snippet' => 'nullable|string',
            'file_upload' => 'nullable|file|max:10240',
            'pg_answers' => 'nullable|array',
        ]);

        // 1. Logika Upload File
        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = Auth::id() . '_' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/submissions'), $fileName);
            $filePath = 'uploads/submissions/' . $fileName;
        }

        // 2. Logika Auto-Grading Pilihan Ganda
        $pgAnswers = $request->pg_answers;
        $pgScore = null;

        if ($assignment->multipleChoices->count() > 0 && !empty($pgAnswers)) {
            $correctCount = 0;
            $totalQuestions = $assignment->multipleChoices->count();

            foreach ($assignment->multipleChoices as $question) {
                if (isset($pgAnswers[$question->id]) && $pgAnswers[$question->id] == $question->correct_answer) {
                    $correctCount++;
                }
            }
            $pgScore = round(($correctCount / $totalQuestions) * 100);
        }

        // 3. Ambil data submission lama
        $submission = \App\Models\Submission::where('user_id', Auth::id())
            ->where('assignment_id', $assignment->id)
            ->first();

        // Ambil File Path Lama jika tidak ada upload baru
        if (!$filePath && $submission && $submission->file_path) {
            $filePath = $submission->file_path;
        }

        // 4. Update / Create Submission
        $newSubmission = \App\Models\Submission::updateOrCreate(
            ['user_id' => Auth::id(), 'assignment_id' => $assignment->id],
            [
                'code_snippet' => $request->code_snippet ?? ($submission->code_snippet ?? null),
                'file_path' => $filePath,
                'pg_answers' => $pgAnswers ? json_encode($pgAnswers) : ($submission->pg_answers ?? null),
                'pg_score' => $pgScore,
                'grade' => ($pgScore !== null && !$request->code_snippet && !$request->hasFile('file_upload')) ? $pgScore : ($submission->grade ?? null),
            ]
        );

        // 5. Simpan History
        \App\Models\SubmissionHistory::create([
            'submission_id' => $newSubmission->id,
            'code_snippet' => $newSubmission->code_snippet,
            'file_path' => $newSubmission->file_path,
        ]);

        return back()->with('success', 'Jawaban berhasil dikirim dan disimpan!');
    }
}
