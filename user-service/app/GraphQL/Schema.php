<?php
namespace App\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Schema as GraphQLSchema;
use App\GraphQL\Mutations\CreateUserMutation;
use App\GraphQL\Queries\UserQuery;

class Schema extends GraphQLSchema
{
    protected $types = [
        'User' => UserType::class,
    ];

    protected $mutations = [
        'createUser' => CreateUserMutation::class,
    ];
}
