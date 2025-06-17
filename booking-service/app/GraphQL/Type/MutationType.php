<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Type\BookingType;
use App\GraphQL\Type\FlightType;
use App\GraphQL\Type\UserType;

class MutationType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createBooking' => [
                    'type' => BookingType::getInstance(),
                    'description' => 'Creates a new booking',
                    'args' => [
                        'user_id' => Type::nonNull(Type::id()),
                        'flight_id' => Type::nonNull(Type::id()),
                        'booking_date' => Type::nonNull(Type::string()),
                        'status' => Type::nonNull(Type::string())
                    ]
                ],
                'updateBooking' => [
                    'type' => BookingType::getInstance(),
                    'description' => 'Updates an existing booking',
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'user_id' => Type::id(),
                        'flight_id' => Type::id(),
                        'booking_date' => Type::string(),
                        'status' => Type::string()
                    ]
                ],
                'deleteBooking' => [
                    'type' => Type::boolean(),
                    'description' => 'Deletes a booking',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ]
            ]
        ]);
    }
} 