<?php

namespace App\GraphQL;

use App\GraphQL\Queries\FlightQuery;
use App\GraphQL\Mutations\FlightMutation;
use App\GraphQL\Types\FlightType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Schema;

class GraphQLSchema extends Schema
{
    protected $types = [
        FlightType::class,
    ];

    protected $queries = [
        'flight' => FlightQuery::class,
    ];

    protected $mutations = [
        'addFlight' => FlightMutation::class,
    ];
}
