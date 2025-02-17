<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuardianStudent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guardian_id',
        'student_id',
        'relationship',
        'is_primary',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'guardian_id' => 'integer',
        'student_id' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardians::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Students::class);
    }
}
