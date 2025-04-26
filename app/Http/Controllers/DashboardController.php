<?php

namespace App\Http\Controllers;

use App\Models\PlaceReview;
use App\Models\Places;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $totalPlaces = Places::count();
        $totalUsers = User::count();
        $pendingPlaces = Places::where('is_active', false)->count();
        $totalReviews = PlaceReview::count();

        $recentReviews = PlaceReview::with(['user', 'place'])
            ->latest()
            ->take(5)
            ->get();

        $topPlace = Places::withCount('reviews')
        ->orderByDesc('reviews_count')
        ->first();

        return view('admin.dashboard', compact(
            'totalPlaces', 'totalUsers', 'pendingPlaces', 'recentReviews', 'totalReviews', 'topPlace'
        ));
    }
    public function dashboard(){
        $user = Auth::user();

        return match($user->role->name) {
            'manager'              => view('manager.dashboard'),
            'owner'                => view('owner.dashboard'),
            'employee'             => view('employee.dashboard'),
            'tour_guide'           => view('guide.dashboard'),
            default                => abort(403),
        };
    }
}
