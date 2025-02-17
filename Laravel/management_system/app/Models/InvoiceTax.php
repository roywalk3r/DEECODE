<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InvoiceTax extends Model
{

    protected  $table = 'invoices_taxes';
// This defines the inverse relationship (belongs to Invoice)
    protected $fillable = [
        'tax_rate_id',
        'invoice_id',
        'label'
    ];

    public function invoice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function taxRate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaxRate::class);
    }
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoices_taxes')
            ->withPivot(['label', 'value', 'is_conditional'])
            ->withTimestamps();
    }
}
