<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerSupport;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CustomerSupportController extends Controller
{
    // Menampilkan semua tiket
    public function index()
    {
        $data = CustomerSupport::all();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    // Menampilkan tiket berdasarkan ID
    public function show($id)
    {
        $data = CustomerSupport::find($id);
        if (!$data) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    // Membuat tiket baru
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'user_id' => 'required|integer',
            'booking_id' => 'nullable|integer',
            'issue' => 'required|integer',
            'status' => 'required|string', // open, in_progress, closed
        ]);

        // Validasi user_id dengan UserService
        $client = new Client();
        try {
            $userResponse = $client->get("http://127.0.0.1:8001/api/users/{$data['user_id']}");
            if ($userResponse->getStatusCode() != 200) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error communicating with UserService', 'error' => $e->getMessage()], 500);
        }

        // Daftar masalah yang mungkin terjadi
        $issues = [
            1 => 'Flight cancelled',
            2 => 'Flight schedule change',
            3 => 'Ticket booking failed',
            4 => 'User identity issue',
        ];

        // Validasi apakah issue yang dipilih valid
        if (!array_key_exists($data['issue'], $issues)) {
            return response()->json(['message' => 'Invalid issue selected'], 400);
        }

        // Deskripsi masalah berdasarkan pilihan issue
        $data['issue_description'] = $issues[$data['issue']];

        // Komunikasi dengan BookingService untuk validasi booking_id
        if (!empty($data['booking_id'])) {
            $client = new Client();
            try {
                $response = $client->get("http://127.0.0.1:8003/api/bookings/{$data['booking_id']}"); 
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

    // Memperbarui tiket berdasarkan ID
    public function update(Request $request, $id)
    {
        $ticket = CustomerSupport::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->update($request->only(['issue', 'status', 'resolved_at']));

        return response()->json([
            'message' => 'Ticket updated successfully',
            'data' => $ticket
        ], 200);
    }

    // Menghapus tiket berdasarkan ID
    public function destroy($id)
    {
        $ticket = CustomerSupport::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }
}