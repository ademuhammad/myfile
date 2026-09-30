<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        // Hitung soal PG jika ada
        $assignments = Assignment::with('classroom')->withCount('multipleChoices')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('guru.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        return view('guru.assignments.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'due_date' => 'required|date|after:today',
            // Validasi Array Pilihan Ganda
            'pg_questions' => 'nullable|array',
            'pg_questions.*.question' => 'required_with:pg_questions|string',
            'pg_questions.*.option_a' => 'required_with:pg_questions|string',
            'pg_questions.*.option_b' => 'required_with:pg_questions|string',
            'pg_questions.*.option_c' => 'required_with:pg_questions|string',
            'pg_questions.*.option_d' => 'required_with:pg_questions|string',
            'pg_questions.*.correct_answer' => 'required_with:pg_questions|in:a,b,c,d',
        ]);

        $assignment = Assignment::create([
            'classroom_id' => $request->classroom_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        // Simpan Soal Pilihan Ganda (Jika ada)
        if ($request->has('pg_questions')) {
            foreach ($request->pg_questions as $pg) {
                if (!empty($pg['question'])) {
                    $assignment->multipleChoices()->create([
                        'question' => $pg['question'],
                        'option_a' => $pg['option_a'],
                        'option_b' => $pg['option_b'],
                        'option_c' => $pg['option_c'],
                        'option_d' => $pg['option_d'],
                        'correct_answer' => $pg['correct_answer'],
                    ]);
                }
            }
        }

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil dibuat!');
    }

    public function edit(Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);

        $classrooms = Classroom::all();
        $assignment->load('multipleChoices'); // Muat data soal PG

        return view('guru.assignments.edit', compact('assignment', 'classrooms'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);

        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'due_date' => 'required|date',
            'pg_questions' => 'nullable|array',
            'pg_questions.*.question' => 'required_with:pg_questions|string',
            'pg_questions.*.correct_answer' => 'required_with:pg_questions|in:a,b,c,d',
        ]);

        $assignment->update($request->only(['classroom_id', 'title', 'description', 'due_date']));

        // Perbarui Soal Pilihan Ganda
        if ($request->has('pg_questions')) {
            $assignment->multipleChoices()->delete(); // Hapus soal PG lama
            foreach ($request->pg_questions as $pg) {
                if (!empty($pg['question'])) {
                    $assignment->multipleChoices()->create([
                        'question' => $pg['question'],
                        'option_a' => $pg['option_a'],
                        'option_b' => $pg['option_b'],
                        'option_c' => $pg['option_c'],
                        'option_d' => $pg['option_d'],
                        'correct_answer' => $pg['correct_answer'],
                    ]);
                }
            }
        } else {
            $assignment->multipleChoices()->delete(); // Jika user menghapus semua soal PG
        }

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);
        $assignment->delete(); // Karena cascadeOnDelete, multiple choices juga terhapus
        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil dihapus!');
    }

    // Fungsi show, submissionHistory, grade, dll dibiarkan tetap sama...
    public function show(Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);
        $assignment->load('multipleChoices');
        $submissions = \App\Models\Submission::with(['student', 'histories'])
            ->where('assignment_id', $assignment->id)->latest()->get();
        return view('guru.assignments.show', compact('assignment', 'submissions'));
    }

    public function submissionHistory(Assignment $assignment, \App\Models\Submission $submission)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);
        $submission->load(['histories' => function ($query) {
            $query->latest();
        }, 'student']);
        return view('guru.assignments.history', compact('assignment', 'submission'));
    }

    public function grade(Request $request, $id)
    {
        $request->validate(['grade' => 'required|numeric|min:0|max:100', 'feedback' => 'nullable|string']);
        $submission = \App\Models\Submission::findOrFail($id);
        if ($submission->assignment->user_id !== Auth::id()) abort(403);
        $submission->update(['grade' => $request->grade, 'feedback' => $request->feedback]);
        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function downloadSubmission($id)
    {
        $submission = \App\Models\Submission::findOrFail($id);
        if ($submission->assignment->user_id !== Auth::id()) abort(403);
        $filePath = public_path($submission->file_path);
        if (!$submission->file_path || !file_exists($filePath)) abort(404, 'File tidak ditemukan.');
        return response()->download($filePath);
    }

    public function downloadHistory($id)
    {
        $history = \App\Models\SubmissionHistory::with('submission.assignment')->findOrFail($id);
        if ($history->submission->assignment->user_id !== Auth::id()) abort(403);
        $filePath = public_path($history->file_path);
        if (!$history->file_path || !file_exists($filePath)) abort(404, 'File tidak ditemukan.');
        return response()->download($filePath);
    }
}
