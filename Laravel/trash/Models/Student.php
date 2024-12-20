<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'class',
        'department',
        'admission_no',
    ];

    // Relationship: A student belongs to a user (parent)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A student can have many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }}
