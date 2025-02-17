<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id',
        'transaction_id',
        'amount',
        'transaction_date',
        'status',
        'payments_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'amount' => 'decimal:2',
        'transaction_date' => 'datetime',
        'payments_id' => 'integer',
    ];

    public function payments(): BelongsTo
    {
        return $this->belongsTo(Payments::class);
    }
}
