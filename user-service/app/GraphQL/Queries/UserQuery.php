<?php
namespace App\GraphQL\Queries;

use App\Models\User;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return ['id' => ['type' => Type::int()]];
    }

    public function resolve($root, $args)
    {
        return isset($args['id']) ? User::find($args['id']) : User::all();
    }
}
