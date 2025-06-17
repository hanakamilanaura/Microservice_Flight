<?php

namespace App\GraphQL\Queries;

use App\Models\Flight;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class FlightQuery extends Query
{
    protected $attributes = [
        'name' => 'flight',
        'description' => 'A query to get flight data'
    ];

    public function type(): Type
    {
        // tipe data FlightType
        return GraphQL::type('Flight');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(), 
                'description' => 'The ID of the flight'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        //  data flight berdasarkan ID yang diberikan
        if (isset($args['id'])) {
            return Flight::find($args['id']);
        }

        //  ID tidak ada, mengembalikan semua penerbangan
        return Flight::all();
    }
}
