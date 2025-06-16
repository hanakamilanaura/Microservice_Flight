<?php

namespace App\GraphQL\Controller;

use App\GraphQL\Schema;
use GraphQL\GraphQL;
use GraphQL\Error\DebugFlag;

class GraphQLController
{
    public function handle()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $query = $input['query'] ?? null;
        $variables = $input['variables'] ?? null;

        try {
            $schema = Schema::getSchema();
            $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
            $output = $result->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE);
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($output);
    }
} 