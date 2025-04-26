<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = [
        'user_id',
        'places_id',
        'scheduled_date',
        'number_of_guests',
        'total_price',
        'status',
        'special_request',
        'payment_status',
        'payment_id',
    ];
}
