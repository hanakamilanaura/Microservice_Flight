<?php

namespace App\GraphQL\Type;

use App\Models\Complaint;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class ComplaintType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Complaint',
            'description' => 'A complaint in the system',
            'fields' => [
                'id' => [
                    'type' => Type::id(),
                    'description' => 'The id of the complaint'
                ],
                'title' => [
                    'type' => Type::string(),
                    'description' => 'The title of the complaint'
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => 'The description of the complaint'
                ],
                'status' => [
                    'type' => Type::string(),
                    'description' => 'The status of the complaint'
                ],
                'created_at' => [
                    'type' => Type::string(),
                    'description' => 'The creation date of the complaint'
                ],
                'updated_at' => [
                    'type' => Type::string(),
                    'description' => 'The last update date of the complaint'
                ]
            ]
        ]);
    }
} 