<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'item_id',
        'name',
        'description',
        'quantity',
        'unit_price',
        'tax_type',
        'tax',
        'discount_type',
        'discount',
        'total',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'invoice_id' => 'integer',
        'item_id' => 'integer',
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'tax_type' => 'boolean',
        'tax' => 'decimal:4',
        'discount_type' => 'boolean',
        'discount' => 'decimal:4',
        'total' => 'decimal:4',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
