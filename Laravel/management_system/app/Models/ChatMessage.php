<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'from',
        'to',
        'read',
        'date',
        'date_read',
        'offline',
        'user_id',
        'from_id',
        'to_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'from' => 'integer',
        'to' => 'integer',
        'date' => 'datetime',
        'date_read' => 'datetime',
        'user_id' => 'integer',
        'from_id' => 'integer',
        'to_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function from(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
