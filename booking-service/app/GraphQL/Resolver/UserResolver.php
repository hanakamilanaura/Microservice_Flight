<?php

namespace App\GraphQL\Resolver;

use App\Services\UserService;

class UserResolver
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser($id)
    {
        return $this->userService->getUser($id);
    }

    public function getUsers()
    {
        return $this->userService->getUsers();
    }
} 