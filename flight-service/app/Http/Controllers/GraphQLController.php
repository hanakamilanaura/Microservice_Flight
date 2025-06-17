<?php

namespace App\Http\Controllers;

use GraphQL;
use GraphQL\Error\FormattedError;
use Illuminate\Http\Request;

class GraphQLController extends Controller
{
    public function handle(Request $request)
    {
        $input = $request->all();
        $query = $input['query'] ?? null;
        $variables = $input['variables'] ?? null;

        if (!$query) {
            return response()->json([
                'errors' => [
                    ['message' => 'No query provided']
                ]
            ], 400);
        }

        try {
            // schema yang telah didaftarkan dalam GraphQL
            $schema = GraphQL::schema();
            $result = GraphQL::executeQuery(
                $schema,
                $query,
                null, 
                null, 
                $variables
            );

            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    FormattedError::createFromException($e)
                ]
            ];
        }

        return response()->json($output);
    }
}
