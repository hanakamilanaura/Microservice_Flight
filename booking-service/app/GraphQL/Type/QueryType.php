<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Type\BookingType;
use App\GraphQL\Type\FlightType;
use App\GraphQL\Type\UserType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'booking' => [
                    'type' => BookingType::getInstance(),
                    'description' => 'Returns booking by id',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
                'bookings' => [
                    'type' => Type::listOf(BookingType::getInstance()),
                    'description' => 'Returns all bookings'
                ],
                'flight' => [
                    'type' => FlightType::getInstance(),
                    'description' => 'Returns flight by id',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
                'flights' => [
                    'type' => Type::listOf(FlightType::getInstance()),
                    'description' => 'Returns all flights'
                ],
                'user' => [
                    'type' => UserType::getInstance(),
                    'description' => 'Returns user by id',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
                'users' => [
                    'type' => Type::listOf(UserType::getInstance()),
                    'description' => 'Returns all users'
                ]
            ]
        ]);
    }
} 