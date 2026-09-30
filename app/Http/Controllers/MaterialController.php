<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
   public function index(\Illuminate\Http\Request $request)
    {
        // Mulai query dasar
        $query = Material::with('classrooms')->where('user_id', Auth::id());

        // Logika Fitur Pencarian (Berdasarkan Judul atau Topik)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('topic', 'like', "%{$search}%");
            });
        }

        // Logika Fitur Urutkan (Sort)
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'a-z':
                    $query->orderBy('title', 'asc');
                    break;
                case 'z-a':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->latest(); // Default terbaru
                    break;
            }
        } else {
            $query->latest();
        }

        // Eksekusi query dengan pagination, tambahkan withQueryString() agar pagination tidak mereset pencarian
        $materials = $query->paginate(10)->withQueryString();

        return view('guru.materials.index', compact('materials'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        return view('guru.materials.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_ids' => 'nullable|array', // Menerima banyak kelas (array)
            'classroom_ids.*' => 'exists:classrooms,id',
            'topic' => 'required|string|max:255', // Validasi Topik baru
            'title' => 'required|string|max:255',
            'content' => 'required',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = Auth::id() . '_' . time() . '_' . $originalName;
            $file->move(public_path('uploads/materials'), $fileName);
            $path = 'uploads/materials/' . $fileName;
        }

        $material = Material::create([
            'user_id' => Auth::id(),
            'topic' => $request->topic, // Simpan Topik
            'title' => $request->title,
            'content' => $request->content,
            'attachment_path' => $path,
        ]);

        // Simpan relasi banyak kelas ke pivot table
        if ($request->filled('classroom_ids')) {
            $material->classrooms()->sync($request->classroom_ids);
        }

        return redirect()->route('materials.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    // Fungsi edit(), update(), destroy(), download(), dan viewFile() disesuaikan
    // agar membaca relasi ->classrooms()
    public function edit(Material $material)
    {
        if ($material->user_id !== Auth::id()) abort(403);
        $classrooms = Classroom::all();
        return view('guru.materials.edit', compact('material', 'classrooms'));
    }

    public function update(Request $request, Material $material)
    {
        if ($material->user_id !== Auth::id()) abort(403);

        $request->validate([
            'classroom_ids' => 'nullable|array',
            'topic' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $path = $material->attachment_path;
        if ($request->hasFile('attachment')) {
            if ($path && file_exists(public_path($path))) unlink(public_path($path));
            $file = $request->file('attachment');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = Auth::id() . '_' . time() . '_' . $originalName;
            $file->move(public_path('uploads/materials'), $fileName);
            $path = 'uploads/materials/' . $fileName;
        }

        $material->update([
            'topic' => $request->topic,
            'title' => $request->title,
            'content' => $request->content,
            'attachment_path' => $path,
        ]);

        // Update relasi kelas
        $material->classrooms()->sync($request->classroom_ids ?? []);

        return redirect()->route('materials.index')->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy(Material $material)
    {
        if ($material->user_id !== Auth::id()) abort(403);
        if ($material->attachment_path && file_exists(public_path($material->attachment_path))) {
            unlink(public_path($material->attachment_path));
        }
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Materi dihapus!');
    }

    public function download(Material $material)
    {
        $user = Auth::user();
        if ($user->role === 'siswa' && !$material->classrooms->contains($user->classroom_id)) abort(403);
        $filePath = public_path($material->attachment_path);
        if (!$material->attachment_path || !file_exists($filePath)) abort(404);
        return response()->download($filePath);
    }

    public function viewFile(Material $material)
    {
        $user = Auth::user();
        if ($user->role === 'siswa' && !$material->classrooms->contains($user->classroom_id)) abort(403);
        $filePath = public_path($material->attachment_path);
        if (!$material->attachment_path || !file_exists($filePath)) abort(404);
        return response()->file($filePath);
    }
}
