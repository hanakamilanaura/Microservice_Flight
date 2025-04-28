<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = [
        'user_id',
        'flight_id',
        'ticket_quantity',
        // 'status',
        'total_price',
    ];
}
