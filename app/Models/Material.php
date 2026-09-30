<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_material');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
