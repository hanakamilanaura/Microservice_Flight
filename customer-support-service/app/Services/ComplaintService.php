<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ComplaintService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://complaint-service:4003/', // Base URL untuk complaint-service
            'timeout'  => 5.0, // Batas waktu request
        ]);
    }

    public function getComplaints()
    {
        try {
            $response = $this->client->request('GET', 'api/complaints'); // Endpoint di complaint-service
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Tangani error
            if ($e->hasResponse()) {
                // Log the response body for debugging
                error_log("Error from ComplaintService: " . $e->getResponse()->getBody()->getContents());
            } else {
                error_log("Request Error to ComplaintService: " . $e->getMessage());
            }
            return [];
        }
    }

    public function createComplaint(array $data)
    {
        try {
            $response = $this->client->request('POST', 'api/complaints', [
                'json' => $data,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                error_log("Error from ComplaintService: " . $e->getResponse()->getBody()->getContents());
            } else {
                error_log("Request Error to ComplaintService: " . $e->getMessage());
            }
            return null;
        }
    }
} 