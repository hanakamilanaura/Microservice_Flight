<?php

return [
    'types' => [
        'User' => App\GraphQL\Types\UserType::class,
    ],

    'queries' => [
        'user' => App\GraphQL\Queries\UserQuery::class,
    ],

    'mutations' => [
        'createUser' => App\GraphQL\Mutations\CreateUserMutation::class,
    ],
];

