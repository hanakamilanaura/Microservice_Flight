<?php

namespace App\GraphQL\Type;

use App\Models\Flight;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'flight' => [
                    'type' => Type::id(),
                    'description' => 'Get a flight by ID',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ],
                    'resolve' => function ($root, $args) {
                        return Flight::find($args['id']);
                    }
                ],
                'flights' => [
                    'type' => Type::listOf(Type::id()),
                    'description' => 'Get all flights',
                    'args' => [
                        'departure_city' => Type::string(),
                        'arrival_city' => Type::string(),
                        'date' => Type::string()
                    ],
                    'resolve' => function ($root, $args) {
                        $query = Flight::query();
                        
                        if (isset($args['departure_city'])) {
                            $query->where('departure_city', $args['departure_city']);
                        }
                        
                        if (isset($args['arrival_city'])) {
                            $query->where('arrival_city', $args['arrival_city']);
                        }
                        
                        if (isset($args['date'])) {
                            $query->whereDate('departure_time', $args['date']);
                        }
                        
                        return $query->get();
                    }
                ]
            ]
        ]);
    }
} 