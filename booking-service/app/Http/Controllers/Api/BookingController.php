<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $data = Booking::all();

        return response()->json([
            'message' => 'success',
            'data'    => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Booking::find($id);

        if (! $data) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data'    => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $userId         = $request->input('user_id');
        $flightId       = $request->input('flight_id');
        $ticketQuantity = $request->input('ticket_quantity');

        $client = new Client();

        // Validasi user dengan melakukan request ke UserService
        $userResponse = $client->get("http://127.0.0.1:8001/api/users/{$userId}");
        if ($userResponse->getStatusCode() != 200) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validasi flight dengan melakukan request ke FlightService
        $flightResponse = $client->get("http://127.0.0.1:8002/api/flights/{$flightId}");
        if ($flightResponse->getStatusCode() != 200) {
            return response()->json(['message' => 'Flight not found'], 404);
        }

        $totalPrice = json_decode($flightResponse->getBody(), true)['data']['price'] * $ticketQuantity;

        // Simpan booking
        $booking = Booking::create([
            'user_id'         => $userId,
            'flight_id'       => $flightId,
            'ticket_quantity' => $ticketQuantity,
            'status'          => 'pending',
            'total_price'     => $totalPrice,
        ]);
        return response()->json([
            'message' => 'Booking created successfully',
            'data'    => $booking,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        $booking->update($request->all());

        return response()->json([
            'message' => 'Booking updated successfully',
            'data'    => $booking,
        ], 200);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully',
        ], 200);
    }
}
