<?php

return [
    'schema' => [
        'default' => \App\GraphQL\GraphQLSchema::class,
    ],
    'types' => [
        // Daftar tipe yang digunakan di GraphQl
        'Flight' => \App\GraphQL\Types\FlightType::class,
    ],
    'security' => [
        'query_max_depth' => 10,
        'query_max_complexity' => 1000,
        'disable_introspection' => false,
    ],
];
