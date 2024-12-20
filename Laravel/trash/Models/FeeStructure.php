<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = [
        'class',
        'term',
        'amount',
        'description',
    ];

    // Relationship: A fee structure can have many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
