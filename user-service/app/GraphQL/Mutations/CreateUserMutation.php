<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => ['type' => Type::string()],
            'email' => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        // Validasi email
        if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email address.");
        }

        // Buat user baru dengan password yang aman
        return User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => bcrypt('defaultPassword'),  // Atau bisa mengambil password dari argumen
        ]);
    }
}