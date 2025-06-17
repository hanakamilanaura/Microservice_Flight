<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        return self::$instance ?: (self::$instance = new self());
    }

    public function __construct()
    {
        parent::__construct([
            'name' => 'User',
            'description' => 'A user in the system',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The id of the user'
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The name of the user'
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The email of the user'
                ],
                'phone' => [
                    'type' => Type::string(),
                    'description' => 'The phone number of the user'
                ],
                'address' => [
                    'type' => Type::string(),
                    'description' => 'The address of the user'
                ]
            ]
        ]);
    }
} 