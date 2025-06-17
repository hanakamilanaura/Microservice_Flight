<?php
namespace App\GraphQL\Queries;

use App\Models\User;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
    ];

    public function type(): Type
    {
        return \GraphQL::type('User');
    }

    public function args(): array
{
    return [
        'id' => ['type' => Type::int()],
    ];
}

public function resolve($root, $args)
{
    if (isset($args['id'])) {
        return User::find($args['id']);
    }
    return User::all();
}

}
