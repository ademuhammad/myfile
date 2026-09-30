<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Siswa (User)
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Tugas (Assignment)
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // TAMBAHKAN FUNGSI INI UNTUK MEMPERBAIKI ERROR
    public function histories()
    {
        // Menghubungkan ke tabel submission_histories dan diurutkan dari yang terbaru
        return $this->hasMany(SubmissionHistory::class)->latest();
    }
}
