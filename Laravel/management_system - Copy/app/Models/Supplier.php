<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];
}
