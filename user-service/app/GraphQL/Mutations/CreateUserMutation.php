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
        'description' => 'Membuat user baru dan password',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nama lengkap user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Alamat email user (harus valid)',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password user (akan di-hash)',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        // Cek validasi email
        if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email address.");
        }

        // Cek apakah user dengan email itu sudah ada
        if (User::where('email', $args['email'])->exists()) {
            throw new \Exception("Email already registered.");
        }

        // Simpan user baru
        return User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => bcrypt($args['password']),
        ]);
    }
}
