<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaxRate extends Model
{
    use HasFactory;
protected  $table = 'tax_rates';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'value',
        'type',
        'is_default',
        'can_delete',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'decimal:2',
        'type' => 'boolean',
        'is_default' => 'boolean',
        'can_delete' => 'boolean',
    ];

    // Relationships
    public function items()
        {
            return $this->hasMany(Item::class);
        }





}
