<?php

namespace App\GraphQL\Types;

use App\Models\User;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user type',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => ['type' => Type::int()],
            'name' => ['type' => Type::string()],
            'email' => ['type' => Type::string()],
        ];
    }
}
