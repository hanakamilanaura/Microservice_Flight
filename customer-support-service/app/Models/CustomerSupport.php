<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    protected $table = 'customer_supports';
    protected $fillable = [
        'user_id',
        'booking_id',
        'issue',
        'status',
        'created_at',
        'resolved_at',  
    ];
}
