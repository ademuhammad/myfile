<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        // Mengambil data kelas untuk ditampilkan di dashboard (opsional)
        $classrooms = \App\Models\Classroom::all();

        return view('guru.dashboard', compact('classrooms'));
    }
}
