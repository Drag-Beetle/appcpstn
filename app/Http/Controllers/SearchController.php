<?php

namespace App\Http\Controllers;

use App\Models\PlaceReview;
use App\Models\Places;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        if (!$q) {
            return view('admin.search.index');
        }

        $users = User::where('name', 'like', "%$q%")
                     ->orWhere('email', 'like', "%$q%")
                     ->limit(5)->get();

        $places = Places::where('name', 'like', "%$q%")
                        ->orWhere('city', 'like', "%$q%")
                        ->limit(5)->get();

        $reviews = PlaceReview::where('comment', 'like', "%$q%")
                              ->limit(5)->get();

        return view('admin.search.index', compact('q', 'users', 'places', 'reviews'));
    }
}
