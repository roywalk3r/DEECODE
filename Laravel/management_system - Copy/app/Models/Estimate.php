<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estimate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'date',
        'date_due',
        'title',
        'description',
        'status',
        'bill_to_id',
        'note',
        'terms',
        'currency',
        'discount_type',
        'subtotal',
        'global_discount',
        'shipping',
        'total_discount',
        'total_tax',
        'total',
        'count',
        'user_id',
        'custom_field1',
        'custom_field2',
        'custom_field3',
        'custom_field4',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'date_due' => 'date',
        'bill_to_id' => 'integer',
        'discount_type' => 'boolean',
        'subtotal' => 'decimal:4',
        'global_discount' => 'decimal:4',
        'shipping' => 'decimal:2',
        'total_discount' => 'decimal:4',
        'total_tax' => 'decimal:4',
        'total' => 'decimal:4',
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

    public function estimateItems(): HasMany
    {
        return $this->hasMany(EstimateItem::class);
    }

    public function estimateTaxes(): HasMany
    {
        return $this->hasMany(EstimateTax::class);
    }
}
