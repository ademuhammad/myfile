<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::latest()->paginate(10);
        return view('guru.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('guru.classrooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);

        Classroom::create([
            'name' => $request->name,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->route('guru.classrooms.index')->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function edit(Classroom $classroom)
    {
        return view('guru.classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);

        $classroom->update([
            'name' => $request->name,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->route('guru.classrooms.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('guru.classrooms.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
