<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Students extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'class_group_id',
        'first_name',
        'last_name',
        'date_of_birth',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'class_group_id' => 'integer',
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ClassGroups::class);
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardians::class);
    }
    public function getFullNameAttribute()
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }
}
