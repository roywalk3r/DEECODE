<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'student_id',
        'fee_structure_id',
        'amount_paid',
        'payment_method',
        'transaction_id',
        'status',
    ];

    // Relationship: A payment belongs to a student
    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship: A payment belongs to a fee structure
    public function fee()
    {
        return $this->belongsTo(FeeStructure::class);
    }

    // Relationship: A payment can have one transaction
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
