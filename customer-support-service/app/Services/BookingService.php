<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BookingService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://booking_app:9000/', // Base URL untuk booking-service app kontainer
            'timeout'  => 5.0,
        ]);
    }

    public function getBooking($bookingId)
    {
        try {
            $response = $this->client->request('GET', "api/bookings/{$bookingId}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            error_log("Error from BookingService: " . ($e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()));
            return null;
        }
    }
} 