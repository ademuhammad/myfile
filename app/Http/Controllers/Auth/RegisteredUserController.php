<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classroom; // Tambahkan ini
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Ambil semua data kelas yang sudah dibuat guru
        $classrooms = Classroom::all();
        return view('auth.register', compact('classrooms'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class], // Ganti email ke username
            'classroom_id' => ['required', 'exists:classrooms,id'], // Validasi kelas
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username, // Simpan username
            'classroom_id' => $request->classroom_id, // Simpan id kelas
            'role' => 'siswa', // Otomatis jadikan sebagai siswa
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Akan otomatis diarahkan ke /dashboard yang sudah kita atur sebelumnya
        return redirect(route('dashboard', absolute: false));
    }
}
