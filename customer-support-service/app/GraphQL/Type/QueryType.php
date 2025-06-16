<?php

namespace App\GraphQL\Type;

use App\Models\Complaint;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'complaint' => [
                    'type' => Type::id(),
                    'description' => 'Get a complaint by ID',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ],
                    'resolve' => function ($root, $args) {
                        return Complaint::find($args['id']);
                    }
                ],
                'complaints' => [
                    'type' => Type::listOf(Type::id()),
                    'description' => 'Get all complaints',
                    'resolve' => function () {
                        return Complaint::all();
                    }
                ]
            ]
        ]);
    }
} 