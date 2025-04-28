<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $data = User::all();

        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function show($id) {
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|',
        ]);
        $data = User::create($request->all());

        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id) {
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $data->update($request->all());
        $data->save();
        

        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function destroy($id) {
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'success',
        ], 200);
    }

    //get bookings detail from another service with id user
    public function getBookings($id)
{
    // Validasi dulu apakah user-nya ada
    $user = User::find($id);
    if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    try {
        // Ambil semua booking dari BookingService
        $client = new Client();
        $response = $client->get("http://127.0.0.1:8003/api/bookings"); // ambil SEMUA bookings

        $allBookings = json_decode($response->getBody(), true)['data'] ?? [];

        // Filter berdasarkan user_id di sisi UserService
        $userBookings = collect($allBookings)->where('user_id', $id)->values();

        return response()->json([
            'message' => 'success',
            'user' => $user,
            'bookings' => $userBookings
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}
}