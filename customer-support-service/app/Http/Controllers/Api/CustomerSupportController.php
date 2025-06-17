<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerSupport;
use App\Services\ComplaintService;
use App\Services\NotificationService;
use App\Services\UserService;
use App\Services\BookingService;
use Illuminate\Http\Request;

class CustomerSupportController extends Controller
{
    protected $complaintService;
    protected $notificationService;
    protected $userService;
    protected $bookingService;

    public function __construct(
        ComplaintService $complaintService,
        NotificationService $notificationService,
        UserService $userService,
        BookingService $bookingService
    )
    {
        $this->complaintService = $complaintService;
        $this->notificationService = $notificationService;
        $this->userService = $userService;
        $this->bookingService = $bookingService;
    }

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
        $user = $this->userService->getUser($data['user_id']);
        if (!$user) {
            return response()->json(['message' => 'User not found or UserService error'], 404);
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
            $booking = $this->bookingService->getBooking($data['booking_id']);
            if (!$booking) {
                return response()->json(['message' => 'Booking not found or BookingService error'], 404);
            }
        }

        // Simpan tiket dukungan
        $ticket = CustomerSupport::create($data);

        // Contoh: Mengirim notifikasi setelah keluhan dibuat (opsional, tergantung alur bisnis)
        // Asumsi notifikasi dikirim ke user yang membuat keluhan
        $this->notificationService->sendNotification([
            'recipient_id' => $data['user_id'], // Sesuaikan dengan ID penerima di NotificationService
            'message' => 'Your complaint for issue "' . $issues[$data['issue']] . '" has been received and is being processed.',
            'type' => 'complaint_received'
        ]);

        // Contoh: Jika ada kebutuhan untuk mengirim keluhan ke ComplaintService
        // Ini mungkin duplikasi jika CustomerSupport sudah menangani inti keluhan.
        // Tapi jika ComplaintService adalah sistem terpisah untuk tracking keluhan, maka ini relevan.
        $complaintExternalData = [
            'ticket_id' => $ticket->id, // ID tiket dari CustomerSupport
            'user_id' => $data['user_id'],
            'issue_description' => $data['issue_description'],
            'status' => $data['status'],
            // Tambahkan data lain yang relevan untuk ComplaintService
        ];
        $this->complaintService->createComplaint($complaintExternalData);

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