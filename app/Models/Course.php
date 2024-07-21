<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_has_courses', 'course_id', 'student_id');
    }
}
