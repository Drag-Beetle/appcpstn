<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlaceReview;
use App\Models\User;
use App\Notifications\NewReviewSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ReviewApiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = PlaceReview::create([
            'place_id' => $validated['place_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'user_id' => $request->user()->id,
        ]);

        $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();
        Notification::send($admins, new NewReviewSubmitted($review));

        return response()->json([
            'message' => 'Review submitted successfully.',
            'review' => $review
        ], 201);
    }
}
