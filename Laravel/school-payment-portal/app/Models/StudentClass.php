<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;




class StudentClass extends Model
{

    protected $fillable = ['name', 'description','student_id', 'class_id'];

    // Relationship: A student class belongs to a student
    public function student()
    {
        return $this->hasMany(Student::class,  'student_class_id');
    }
    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class, 'student_class_id');
    }

    // Relationship: A student belongs to a StudentClass




}

