<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $data = Flight::all();

        return response()->json([
            'message' => 'success',
            'data' => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Flight::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $data = Flight::create($request->all());

        return response()->json([
            'message' => 'Flight created successfully',
            'data' => $data,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        $flight->update($request->all());

        return response()->json([
            'message' => 'Flight updated successfully',
            'data' => $flight,
        ], 200);
    }

    public function destroy($id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        $flight->delete();

        return response()->json([
            'message' => 'Flight deleted successfully',
        ], 200);
    }
}
