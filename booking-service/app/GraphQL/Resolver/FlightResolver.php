<?php

namespace App\GraphQL\Resolver;

use App\Services\FlightService;

class FlightResolver
{
    private $flightService;

    public function __construct(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    public function getFlight($id)
    {
        return $this->flightService->getFlight($id);
    }

    public function getFlights()
    {
        return $this->flightService->getFlights();
    }
} 