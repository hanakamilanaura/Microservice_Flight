<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'user_id' => 1,
            'flight_id' => 101,
            'ticket_quantity' => 2,
            'total_price' => 1500000.00,
        ]);
        Booking::create([
            'user_id' => 2,
            'flight_id' => 102,
            'ticket_quantity' => 1,
            'total_price' => 800000.00,
        ]);
        Booking::create([
            'user_id' => 1,
            'flight_id' => 103,
            'ticket_quantity' => 3,
            'total_price' => 2250000.00,
        ]);
    }
} 