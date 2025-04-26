<?php

namespace App\Http\Controllers;

use App\Models\PlaceReview;
use App\Models\User;
use App\Notifications\NewReviewSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = PlaceReview::with(['user', 'place'])
            ->when($request->rating, fn($q) => $q->where('rating', $request->rating))
            ->when($request->place, fn($q) => $q->whereHas('place', fn($q2) => $q2->where('name', 'like', "%{$request->place}%")))
            ->when($request->user, fn($q) => $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$request->user}%")))
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(PlaceReview $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }

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
            'user_id' => Auth::id(),
        ]);

        $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();
        Notification::send($admins, new NewReviewSubmitted($review));

        return redirect()->route('admin.reviews.index')->with('success', 'Review submitted and admins notified.');
    }
}
