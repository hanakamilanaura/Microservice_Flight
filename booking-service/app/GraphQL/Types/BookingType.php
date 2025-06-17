<?php

namespace App\GraphQL\Types;

use App\Models\Booking;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Field;

class BookingType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Booking',
        'description' => 'A booking record'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The ID of the booking'
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'User ID for this booking'
            ],
            'flight_id' => [
                'type' => Type::int(),
                'description' => 'Flight ID for this booking'
            ],
            'ticket_quantity' => [
                'type' => Type::int(),
                'description' => 'Number of tickets booked'
            ],
            'total_price' => [
                'type' => Type::float(),
                'description' => 'Total price of the booking'
            ]
        ];
    }
}
