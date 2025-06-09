<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UserService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://user_app:9000/', // Base URL untuk user-service app kontainer
            'timeout'  => 5.0,
        ]);
    }

    public function getUser($userId)
    {
        try {
            $response = $this->client->request('GET', "api/users/{$userId}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            error_log("Error from UserService: " . ($e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()));
            return null;
        }
    }
} 