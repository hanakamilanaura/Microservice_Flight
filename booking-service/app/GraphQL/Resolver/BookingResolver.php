<?php

namespace App\GraphQL\Resolver;

use App\Models\Booking;
use App\Services\FlightService;
use App\Services\UserService;

class BookingResolver
{
    private $flightService;
    private $userService;

    public function __construct(FlightService $flightService, UserService $userService)
    {
        $this->flightService = $flightService;
        $this->userService = $userService;
    }

    public function getBooking($id)
    {
        return Booking::find($id);
    }

    public function getBookings()
    {
        return Booking::all();
    }

    public function createBooking($args)
    {
        $booking = new Booking();
        $booking->user_id = $args['user_id'];
        $booking->flight_id = $args['flight_id'];
        $booking->booking_date = $args['booking_date'];
        $booking->status = $args['status'];
        $booking->save();
        return $booking;
    }

    public function updateBooking($args)
    {
        $booking = Booking::find($args['id']);
        if (!$booking) {
            return null;
        }

        $fields = ['user_id', 'flight_id', 'booking_date', 'status'];
        foreach ($fields as $field) {
            if (isset($args[$field])) {
                $booking->$field = $args[$field];
            }
        }

        $booking->save();
        return $booking;
    }

    public function deleteBooking($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return false;
        }
        return $booking->delete();
    }

    public function getFlight($booking)
    {
        return $this->flightService->getFlight($booking->flight_id);
    }

    public function getUser($booking)
    {
        return $this->userService->getUser($booking->user_id);
    }
} 