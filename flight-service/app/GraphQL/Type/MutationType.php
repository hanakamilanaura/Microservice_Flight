<?php

namespace App\GraphQL\Type;

use App\Models\Flight;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class MutationType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createFlight' => [
                    'type' => Type::id(),
                    'description' => 'Create a new flight',
                    'args' => [
                        'flight_number' => Type::nonNull(Type::string()),
                        'departure_city' => Type::nonNull(Type::string()),
                        'arrival_city' => Type::nonNull(Type::string()),
                        'departure_time' => Type::nonNull(Type::string()),
                        'arrival_time' => Type::nonNull(Type::string()),
                        'price' => Type::nonNull(Type::float()),
                        'available_seats' => Type::nonNull(Type::int())
                    ],
                    'resolve' => function ($root, $args) {
                        $flight = new Flight();
                        $flight->flight_number = $args['flight_number'];
                        $flight->departure_city = $args['departure_city'];
                        $flight->arrival_city = $args['arrival_city'];
                        $flight->departure_time = $args['departure_time'];
                        $flight->arrival_time = $args['arrival_time'];
                        $flight->price = $args['price'];
                        $flight->available_seats = $args['available_seats'];
                        $flight->save();
                        return $flight;
                    }
                ],
                'updateFlight' => [
                    'type' => Type::id(),
                    'description' => 'Update an existing flight',
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'flight_number' => Type::string(),
                        'departure_city' => Type::string(),
                        'arrival_city' => Type::string(),
                        'departure_time' => Type::string(),
                        'arrival_time' => Type::string(),
                        'price' => Type::float(),
                        'available_seats' => Type::int()
                    ],
                    'resolve' => function ($root, $args) {
                        $flight = Flight::find($args['id']);
                        if (!$flight) {
                            return null;
                        }
                        
                        $fields = [
                            'flight_number', 'departure_city', 'arrival_city',
                            'departure_time', 'arrival_time', 'price', 'available_seats'
                        ];
                        
                        foreach ($fields as $field) {
                            if (isset($args[$field])) {
                                $flight->$field = $args[$field];
                            }
                        }
                        
                        $flight->save();
                        return $flight;
                    }
                ],
                'deleteFlight' => [
                    'type' => Type::boolean(),
                    'description' => 'Delete a flight',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ],
                    'resolve' => function ($root, $args) {
                        $flight = Flight::find($args['id']);
                        if (!$flight) {
                            return false;
                        }
                        return $flight->delete();
                    }
                ]
            ]
        ]);
    }
} 