<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. Route Dashboard Utama (Redirector ke dashboard masing-masing)
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'guru') {
        return redirect()->route('guru.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth'])->name('dashboard');

// 2. Route Umum (Bisa diakses Guru & Siswa yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk unduh dan lihat file materi
    Route::get('/material/{material}/download', [MaterialController::class, 'download'])->name('materials.download');
    Route::get('/material/{material}/view', [MaterialController::class, 'viewFile'])->name('materials.view');
});

// 3. Route Khusus Guru
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');

    // CRUD Materi dan Tugas untuk Guru
    Route::resource('guru/materials', MaterialController::class);
    Route::resource('guru/assignments', AssignmentController::class);
    Route::get('/guru/assignments/{assignment}/submissions/{submission}/history', [AssignmentController::class, 'submissionHistory'])->name('guru.assignments.history');
    Route::post('/guru/submissions/{id}/grade', [AssignmentController::class, 'grade'])->name('assignments.grade');
    Route::get('/guru/submissions/{id}/download', [AssignmentController::class, 'downloadSubmission'])->name('assignments.submission.download');
    Route::get('/guru/submissions/history/{id}/download', [AssignmentController::class, 'downloadHistory'])->name('assignments.history.download');
    Route::resource('guru/users', UserController::class)->names('guru.users');
    Route::resource('guru/classrooms', ClassroomController::class)->names('guru.classrooms');
});

// 4. Route Khusus Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');

    // Halaman List Materi & Tugas terpisah
    Route::get('/siswa/materials', [SiswaController::class, 'materials'])->name('siswa.materials.index');
    Route::get('/siswa/assignments', [SiswaController::class, 'assignments'])->name('siswa.assignments.index');

    // Halaman Detail dan Pengumpulan Tugas
    Route::get('/siswa/assignments/{assignment}', [SiswaController::class, 'showAssignment'])->name('siswa.assignments.show');

    // PERBAIKAN: Hanya 1 rute POST untuk submit (menggunakan method submit)
    Route::post('/siswa/assignments/{assignment}', [SiswaController::class, 'submit'])->name('siswa.assignments.submit');
});

require __DIR__ . '/auth.php';
