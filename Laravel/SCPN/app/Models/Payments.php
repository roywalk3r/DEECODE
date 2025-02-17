<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'payment_method_id',
        'amount',
        'payment_date',
        'status',
        'invoices_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_method_id' => 'integer',
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'invoices_id' => 'integer',
    ];

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoices::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(\App\Models\PaymentMethods::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(\App\Models\Transactions::class);
    }
}
