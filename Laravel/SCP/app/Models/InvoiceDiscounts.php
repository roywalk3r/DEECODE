<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDiscounts extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'discount_id',
        'amount',
        'invoices_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'discount_id' => 'integer',
        'amount' => 'decimal:2',
        'invoices_id' => 'integer',
    ];

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoices::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Discounts::class);
    }
}
