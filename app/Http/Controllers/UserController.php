<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
   public function index()
    {
        // Hanya ambil user dengan role 'siswa' dan gunakan pagination
        $users = \App\Models\User::with('classroom')
            ->where('role', 'siswa')
            ->latest()
            ->paginate(10);

        return view('guru.users.index', compact('users'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        return view('guru.users.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // Paksa role menjadi siswa
            'classroom_id' => $request->classroom_id,
        ]);

        return redirect()->route('guru.users.index')->with('success', 'Akun siswa berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'siswa') {
            abort(403, 'Anda hanya dapat mengedit data siswa.');
        }

        $classrooms = Classroom::all();
        return view('guru.users.edit', compact('user', 'classrooms'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'siswa') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6', // Password opsional saat edit
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'classroom_id' => $request->classroom_id,
        ];

        // Jika form password diisi, berarti guru ingin mereset password siswa
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('guru.users.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'siswa') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('guru.users.index')->with('success', 'Akun siswa berhasil dihapus!');
    }
}
