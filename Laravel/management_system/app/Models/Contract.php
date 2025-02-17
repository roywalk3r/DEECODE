<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'biller_id',
        'date',
        'date_due',
        'type',
        'amount',
        'currency',
        'description',
        'reference',
        'count',
        'attachments',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'biller_id' => 'integer',
        'date' => 'date',
        'date_due' => 'date',
        'amount' => 'decimal:2',
        'user_id' => 'integer',
    ];

    public function biller(): BelongsTo
    {
        return $this->belongsTo(Biller::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
