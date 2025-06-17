<?php

namespace App\GraphQL\Queries;

use App\Models\Booking;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Field;

class BookingQuery extends Query
{
    protected $attributes = [
        'name' => 'BookingsQuery'
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('Booking'));
    }

    public function resolve($root, $args)
    {
        return Booking::all();  // You can customize it for filtering or pagination
    }
}
