<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();

        // Mengambil Statistik Utama untuk Dashboard
        $totalClassrooms = Classroom::count();
        $totalStudents = User::where('role', 'siswa')->count();
        $totalMaterials = Material::where('user_id', $guruId)->count();
        $totalAssignments = Assignment::where('user_id', $guruId)->count();

        // Mengambil Data Kelas
        $classrooms = Classroom::all();

        return view('guru.dashboard', compact(
            'totalClassrooms',
            'totalStudents',
            'totalMaterials',
            'totalAssignments',
            'classrooms'
        ));
    }
}
