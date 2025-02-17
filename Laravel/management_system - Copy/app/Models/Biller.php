<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biller extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'phone',
        'email',
        'dob',
        'kyc',
        'website',
        'address',
        'address2',
        'city',
        'state',
        'postal_code',
        'country',
        'company',
        'vat_number',
        'user_id',
        'custom_field1',
        'custom_field2',
        'custom_field3',
        'custom_field4',
        'student_name',
        'school_name',
        'school_location',
        'hall',
        'guardian',
        'school_year',
        'dob_student',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
        'user_id' => 'integer',
        'dob_student' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
