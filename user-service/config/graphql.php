<?php

use Rebing\GraphQL\Support\UploadType;

return [

    // Default schema
    'default_schema' => 'default',

    // Daftar schema yang bisa digunakan
    'schemas' => [
        'default' => [
            'query' => [
                'user' => \App\GraphQL\Queries\UserQuery::class,
            ],
            'mutation' => [
                'createUser' => \App\GraphQL\Mutations\CreateUserMutation::class,
            ],
            'types' => [
                'User' => \App\GraphQL\Types\UserType::class,
            ],
        ],
    ],

    // Daftar semua types global
    'types' => [
        'User' => \App\GraphQL\Types\UserType::class,
    ],

    // GraphQL route
    'route' => [
        'uri' => '/graphql',
        'name' => 'graphql',
        'middleware' => ['api'], // bisa juga: ['web']
    ],

    // GraphQL controller
    'controllers' => \Rebing\GraphQL\GraphQLController::class.'@query',

    // GraphiQL GUI
    'graphiql' => [
        'routes' => '/graphiql',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => ['web'],
        'view' => 'graphql::graphiql',
    ],

    'params_key'    => 'params',
    'types_map' => [
        'Upload' => UploadType::class,
    ],
];
