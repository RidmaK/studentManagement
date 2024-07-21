<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'guardian_id',
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class,'guardian_id','id');
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_has_courses', 'student_id', 'course_id');
    }
}
