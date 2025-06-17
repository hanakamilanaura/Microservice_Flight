<?php

namespace App\GraphQL;

use App\GraphQL\Queries\BookingQuery;
use App\GraphQL\Mutations\BookingMutation;
use App\GraphQL\Types\BookingType;
use Rebing\GraphQL\Support\Schema as GraphQLSchema;

class BookingSchema extends GraphQLSchema
{
    protected $query = BookingQuery::class;
    protected $mutation = BookingMutation::class;
    protected $types = [
        'Booking' => BookingType::class
    ];
}
