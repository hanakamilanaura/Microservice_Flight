<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NotificationService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://notification-service:4004/', // Base URL untuk notification-service
            'timeout'  => 5.0,
        ]);
    }

    public function sendNotification(array $data)
    {
        try {
            $response = $this->client->request('POST', 'api/send', [
                'json' => $data,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                error_log("Error from NotificationService: " . $e->getResponse()->getBody()->getContents());
            } else {
                error_log("Request Error to NotificationService: " . $e->getMessage());
            }
            return null;
        }
    }
} 