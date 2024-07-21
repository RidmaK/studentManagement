<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHasCourses extends Model
{
    use HasFactory;

    protected $table = "student_has_courses";

    protected $fillable = [
        'student_id',
        'course_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
