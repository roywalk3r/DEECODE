<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeStructures extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'amount',
        'effective_date',
        'class_group_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'amount' => 'decimal:2',
        'effective_date' => 'date',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class);
    }
    public function classGroup()
    {
        return $this->belongsTo(ClassGroups::class, 'class_group_id');
    }

}
