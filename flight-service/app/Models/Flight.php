<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $table = 'flights';
    protected $fillable = [
        'flight_code',
        'airline_name',
        'departure_time',
        'arrival_time',
        'price',
        'from',
        'to',
    ];
}
