<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class FlightType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        return self::$instance ?: (self::$instance = new self());
    }

    public function __construct()
    {
        parent::__construct([
            'name' => 'Flight',
            'description' => 'A flight in the system',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The id of the flight'
                ],
                'flight_number' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The flight number'
                ],
                'departure_airport' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The departure airport'
                ],
                'arrival_airport' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The arrival airport'
                ],
                'departure_time' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The departure time'
                ],
                'arrival_time' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The arrival time'
                ],
                'price' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'The price of the flight'
                ],
                'available_seats' => [
                    'type' => Type::nonNull(Type::int()),
                    'description' => 'The number of available seats'
                ]
            ]
        ]);
    }
} 