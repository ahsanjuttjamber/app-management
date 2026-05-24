<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'customer_name',
        'phone_number',
        'status',
        'lock_type',
        'is_blocked',
        'is_fully_paid',
        'last_latitude',
        'last_longitude',
        'last_location_at'
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'is_fully_paid' => 'boolean',
        'last_location_at' => 'datetime'
    ];
}
