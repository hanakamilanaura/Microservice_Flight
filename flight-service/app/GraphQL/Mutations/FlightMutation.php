<?php

namespace App\GraphQL\Mutations;

use App\Models\Flight;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class FlightMutation extends Mutation
{
    protected $attributes = [
        'name' => 'addFlight',
        'description' => 'A mutation to add a new flight'
    ];

    public function type(): Type
    {
        // Mengembalikan tipe data FlightType
        return GraphQL::type('Flight');
    }

    public function args(): array
    {
        return [
            'flight_code' => [
                'type' => Type::string(),
                'description' => 'Flight code'
            ],
            'airline_name' => [
                'type' => Type::string(),
                'description' => 'Airline name'
            ],
            'departure_time' => [
                'type' => Type::string(),
                'description' => 'Departure time'
            ],
            'arrival_time' => [
                'type' => Type::string(),
                'description' => 'Arrival time'
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'Flight price'
            ],
            'from' => [
                'type' => Type::string(),
                'description' => 'Departure location'
            ],
            'to' => [
                'type' => Type::string(),
                'description' => 'Arrival location'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return Flight::create([
            'flight_code' => $args['flight_code'],
            'airline_name' => $args['airline_name'],
            'departure_time' => $args['departure_time'],
            'arrival_time' => $args['arrival_time'],
            'price' => $args['price'],
            'from' => $args['from'],
            'to' => $args['to'],
        ]);
    }
}
