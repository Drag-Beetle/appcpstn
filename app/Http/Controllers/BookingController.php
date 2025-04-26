<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'places_id'        => 'required|exists:places,id',
            'scheduled_date'   => 'required|date',
            'number_of_guests' => 'required|integer|min:1',
            'special_request'  => 'nullable|string',
        ]);
        
        $booking = new Bookings($validated);
        $booking->user_id = Auth::id();
        $booking->save();

        return response()->json([
            'message' => 'Booking created successfully',
            'data'    => $booking,
        ], 201);
    }
    public function show(){
        $bookings = Bookings::all();
        return response()->json($bookings);
    }
}
