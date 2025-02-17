<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecurringInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date',
        'next_date',
        'type',
        'frequency',
        'number',
        'occurence',
        'status',
        'data',
        'bill_to_id',
        'amount',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'next_date' => 'date',
        'bill_to_id' => 'integer',
        'amount' => 'decimal:2',
        'user_id' => 'integer',
    ];

    public function billTo(): BelongsTo
    {
        return $this->belongsTo(Biller::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recurringInvoiceItems(): HasMany
    {
        return $this->hasMany(RecurringInvoiceItem::class);
    }
}
