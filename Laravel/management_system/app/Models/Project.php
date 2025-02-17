<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'biller_id',
        'progress',
        'billing_type',
        'rate',
        'currency',
        'estimated_hours',
        'status',
        'date',
        'date_due',
        'members',
        'description',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'biller_id' => 'integer',
        'rate' => 'decimal:4',
        'date' => 'date',
        'date_due' => 'date',
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

    public function projectTasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }
}
