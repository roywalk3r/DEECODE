<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'payment_id',
        'gateway_response',
        'status',
    ];

    // Relationship: A transaction belongs to a payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }}
