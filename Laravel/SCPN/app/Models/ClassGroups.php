<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassGroups extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'teacher_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'teacher_id' => 'integer',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(\App\Models\Students::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(\App\Models\Schedules::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Teachers::class);
    }
}
