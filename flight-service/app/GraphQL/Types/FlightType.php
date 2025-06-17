<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class FlightType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Flight',
        'description' => 'Details about a flight',
        'model' => \App\Models\Flight::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The ID of the flight'
            ],
            'flight_code' => [
                'type' => Type::string(),
                'description' => 'The flight code'
            ],
            'airline_name' => [
                'type' => Type::string(),
                'description' => 'The airline name'
            ],
            'departure_time' => [
                'type' => Type::string(),
                'description' => 'The departure time of the flight'
            ],
            'arrival_time' => [
                'type' => Type::string(),
                'description' => 'The arrival time of the flight'
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'The price of the flight'
            ],
            'from' => [
                'type' => Type::string(),
                'description' => 'Departure location'
            ],
            'to' => [
                'type' => Type::string(),
                'description' => 'Arrival location'
            ],
        ];
    }
}
