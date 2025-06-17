<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Field;

class BookingMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateBooking'
    ];

    public function type(): Type
    {
        return \GraphQL::type('Booking');
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int())
            ],
            'flight_id' => [
                'name' => 'flight_id',
                'type' => Type::nonNull(Type::int())
            ],
            'ticket_quantity' => [
                'name' => 'ticket_quantity',
                'type' => Type::nonNull(Type::int())
            ],
            'total_price' => [
                'name' => 'total_price',
                'type' => Type::nonNull(Type::float())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return Booking::create($args);
    }
}
