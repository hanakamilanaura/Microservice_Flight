<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerSupport;
use GuzzleHttp\Client; 
use Illuminate\Http\Request;

class CustomerSupportController extends Controller
{
    // membuat tiket baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'booking_id' => 'nullable|integer',
            'issue' => 'required|string',
            // open, in_progress, closed
            'status' => 'required|string', 
        ]);

        // Komunikasi dengan BookingService
        if (!empty($data['booking_id'])) {
            $client = new Client();
            try {
                $response = $client->get("http://127.0.0.1:8002/api/bookings/{$data['booking_id']}"); 
                if ($response->getStatusCode() != 200) {
                    return response()->json(['message' => 'Booking not found'], 404);
                }
                $bookingData = json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error communicating with BookingService', 'error' => $e->getMessage()], 500);
            }
        }

        // Simpan tiket dukungan
        $ticket = CustomerSupport::create($data);

        return response()->json([
            'message' => 'Ticket created',
            'data' => $ticket,
        ], 201);
    }

    // Menampilkan detail tiket
    public function show($id)
    {
        $ticket = CustomerSupport::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        return response()->json(['data' => $ticket], 200);
    }

    // Update status
    public function update(Request $request, $id)
    {
        $ticket = CustomerSupport::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->update($request->only(['issue', 'status', 'resolved_at']));

        return response()->json([
            'message' => 'Ticket updated',
            'data' => $ticket,
        ], 200);
    }

    // Menghapus tiket
    public function destroy($id)
    {
        $ticket = CustomerSupport::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted'], 200);
    }
}
