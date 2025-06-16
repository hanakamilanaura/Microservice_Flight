<?php

namespace App\GraphQL\Type;

use App\Models\Flight;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class FlightType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Flight',
            'description' => 'A flight in the system',
            'fields' => [
                'id' => [
                    'type' => Type::id(),
                    'description' => 'The id of the flight'
                ],
                'flight_number' => [
                    'type' => Type::string(),
                    'description' => 'The flight number'
                ],
                'departure_city' => [
                    'type' => Type::string(),
                    'description' => 'The departure city'
                ],
                'arrival_city' => [
                    'type' => Type::string(),
                    'description' => 'The arrival city'
                ],
                'departure_time' => [
                    'type' => Type::string(),
                    'description' => 'The departure time'
                ],
                'arrival_time' => [
                    'type' => Type::string(),
                    'description' => 'The arrival time'
                ],
                'price' => [
                    'type' => Type::float(),
                    'description' => 'The price of the flight'
                ],
                'available_seats' => [
                    'type' => Type::int(),
                    'description' => 'Number of available seats'
                ],
                'created_at' => [
                    'type' => Type::string(),
                    'description' => 'The creation date'
                ],
                'updated_at' => [
                    'type' => Type::string(),
                    'description' => 'The last update date'
                ]
            ]
        ]);
    }
} 