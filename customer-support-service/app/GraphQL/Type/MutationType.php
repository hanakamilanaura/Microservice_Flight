<?php

namespace App\GraphQL\Type;

use App\Models\Complaint;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class MutationType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createComplaint' => [
                    'type' => Type::id(),
                    'description' => 'Create a new complaint',
                    'args' => [
                        'title' => Type::nonNull(Type::string()),
                        'description' => Type::nonNull(Type::string()),
                        'status' => Type::string()
                    ],
                    'resolve' => function ($root, $args) {
                        $complaint = new Complaint();
                        $complaint->title = $args['title'];
                        $complaint->description = $args['description'];
                        $complaint->status = $args['status'] ?? 'pending';
                        $complaint->save();
                        return $complaint;
                    }
                ],
                'updateComplaint' => [
                    'type' => Type::id(),
                    'description' => 'Update an existing complaint',
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'title' => Type::string(),
                        'description' => Type::string(),
                        'status' => Type::string()
                    ],
                    'resolve' => function ($root, $args) {
                        $complaint = Complaint::find($args['id']);
                        if (!$complaint) {
                            return null;
                        }
                        if (isset($args['title'])) {
                            $complaint->title = $args['title'];
                        }
                        if (isset($args['description'])) {
                            $complaint->description = $args['description'];
                        }
                        if (isset($args['status'])) {
                            $complaint->status = $args['status'];
                        }
                        $complaint->save();
                        return $complaint;
                    }
                ],
                'deleteComplaint' => [
                    'type' => Type::boolean(),
                    'description' => 'Delete a complaint',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ],
                    'resolve' => function ($root, $args) {
                        $complaint = Complaint::find($args['id']);
                        if (!$complaint) {
                            return false;
                        }
                        return $complaint->delete();
                    }
                ]
            ]
        ]);
    }
} 