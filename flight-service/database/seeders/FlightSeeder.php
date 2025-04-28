<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run()
    {
        $flights = [
            [
                'flight_code' => 'GA123',
                'airline_name' => 'Garuda Indonesia',
                'departure_time' => '2025-05-01 10:00:00',
                'from' => 'Jakarta',
                'to' => 'Bali',
                'price' => 1500000,
            ],
            [
                'flight_code' => 'AI456',
                'airline_name' => 'Air India',
                'departure_time' => '2025-05-01 11:30:00',
                'from' => 'Delhi',
                'to' => 'Mumbai',
                'price' => 1200000,
            ],
            [
                'flight_code' => 'QF789',
                'airline_name' => 'Qantas Airways',
                'departure_time' => '2025-05-01 15:00:00',
                'from' => 'Sydney',
                'to' => 'Melbourne',
                'price' => 1800000,
            ],
            [
                'flight_code' => 'BA321',
                'airline_name' => 'British Airways',
                'departure_time' => '2025-05-01 08:45:00',
                'from' => 'London',
                'to' => 'Paris',
                'price' => 1100000,
            ],
            [
                'flight_code' => 'CX654',
                'airline_name' => 'Cathay Pacific',
                'departure_time' => '2025-05-01 13:20:00',
                'from' => 'Hong Kong',
                'to' => 'Tokyo',
                'price' => 1700000,
            ],
            [
                'flight_code' => 'EK987',
                'airline_name' => 'Emirates',
                'departure_time' => '2025-05-01 16:15:00',
                'from' => 'Dubai',
                'to' => 'New York',
                'price' => 4500000,
            ],
            [
                'flight_code' => 'NH234',
                'airline_name' => 'All Nippon Airways',
                'departure_time' => '2025-05-01 19:00:00',
                'from' => 'Tokyo',
                'to' => 'Los Angeles',
                'price' => 4000000,
            ],
            [
                'flight_code' => 'AF567',
                'airline_name' => 'Air France',
                'departure_time' => '2025-05-01 17:50:00',
                'from' => 'Paris',
                'to' => 'Rome',
                'price' => 1400000,
            ],
            [
                'flight_code' => 'SQ890',
                'airline_name' => 'Singapore Airlines',
                'departure_time' => '2025-05-01 09:30:00',
                'from' => 'Singapore',
                'to' => 'Bangkok',
                'price' => 1300000,
            ],
            [
                'flight_code' => 'JL123',
                'airline_name' => 'Japan Airlines',
                'departure_time' => '2025-05-01 12:10:00',
                'from' => 'Osaka',
                'to' => 'Seoul',
                'price' => 1250000,
            ],
        ];

        foreach ($flights as $flight) {
            $departure = Carbon::parse($flight['departure_time']);
            $arrival = (clone $departure)->addHours(2); // Tambahkan 2 jam tetap

            Flight::create([
                'flight_code' => $flight['flight_code'],
                'airline_name' => $flight['airline_name'],
                'departure_time' => $departure,
                'arrival_time' => $arrival,
                'from' => $flight['from'],
                'to' => $flight['to'],
                'price' => $flight['price'],
            ]);
        }
    }
}
