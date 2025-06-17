<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Type\FlightType;
use App\GraphQL\Type\UserType;

class BookingType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        return self::$instance ?: (self::$instance = new self());
    }

    public function __construct()
    {
        parent::__construct([
            'name' => 'Booking',
            'description' => 'A booking in the system',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The id of the booking'
                ],
                'user_id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The id of the user who made the booking'
                ],
                'flight_id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The id of the flight being booked'
                ],
                'booking_date' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The date of the booking'
                ],
                'status' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The status of the booking'
                ],
                'user' => [
                    'type' => UserType::getInstance(),
                    'description' => 'The user who made the booking'
                ],
                'flight' => [
                    'type' => FlightType::getInstance(),
                    'description' => 'The flight being booked'
                ]
            ]
        ]);
    }
} 