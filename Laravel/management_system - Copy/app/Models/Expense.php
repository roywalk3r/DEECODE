<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'reference',
        'category',
        'date',
        'date_due',
        'status',
        'amount',
        'tax_id',
        'tax_type',
        'tax_value',
        'tax_total',
        'total',
        'total_due',
        'payment_method',
        'payment_date',
        'details',
        'attachments',
        'supplier_id',
        'currency',
        'user_id',
        'approval_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'date_due' => 'date',
        'amount' => 'decimal:4',
        'tax_type' => 'boolean',
        'tax_value' => 'decimal:4',
        'tax_total' => 'decimal:4',
        'total' => 'decimal:4',
        'total_due' => 'decimal:4',
        'payment_date' => 'date',
        'supplier_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
