<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = ['id'];

    // Cast due_date agar menjadi object Carbon otomatis
    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function histories()
    {
        return $this->hasMany(SubmissionHistory::class)->latest();
    }
    public function multipleChoices()
    {
        return $this->hasMany(MultipleChoice::class);
    }
}
