<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendances extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'class_group_id',
        'date',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'student_id' => 'integer',
        'class_group_id' => 'integer',
        'date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Students::class);
    }

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ClassGroups::class);
    }
}
