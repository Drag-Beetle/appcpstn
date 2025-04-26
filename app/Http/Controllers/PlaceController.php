<?php

namespace App\Http\Controllers;

use App\Models\PlacePhoto;
use App\Models\Places;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use NewPlaceSubmitted;

class PlaceController extends Controller
{
    public function show(){  //API for Mobile
        $places = Places::all();
        return response()->json($places);
    }

    //Put all the Web Api under this section---------------------------------------------------------------------------------------

    public function index(Request $request)
{
    $places = Places::with([
            'photos' => fn($q) => $q->where('is_primary', true),
        ])
        ->withCount('reviews')
        ->when($request->city, fn($q) => $q->where('city', 'like', '%' . $request->city . '%'))
        ->when($request->status, fn($q) => $q->where('is_active', $request->status === 'active'))
        ->latest()
        ->paginate(10)
        ->appends($request->query());

    return view('admin.places.index', compact('places'));
}


    public function create(){
        return view ('admin.places.create');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'type' => 'required|in:resort,restaurant,market,port,bank,fortress,church,park',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'photo.*' => 'nullable|image|max:2048',
    ]);

    $validated['created_by'] = Auth::id();
    $validated['updated_by'] = Auth::id();

    $place = Places::create($validated);

    $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();
    Notification::send($admins, new NewPlaceSubmitted($place));

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $index => $photo) {
            $path = $photo->store('place_photos', 'public');
            PlacePhoto::create([
                'place_id' => $place->id,
                'image_url' => $path,
                'is_primary' => $index === 0
            ]);
        }
    }


    return redirect()->route('places.index')->with('success', 'Place created');
}

public function edit(Places $place)
{
    return view('admin.places.edit', compact('place'));
}

public function update(Request $request, Places $place)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'type' => 'required|in:resort,restaurant,market,port,bank,fortress,church,park',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'photos.*' => 'nullable|image|max:2048',
    ]);

    $validated['updated_by'] = Auth::id();
    $place->update($validated);

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('place_photos', 'public');
            PlacePhoto::create([
                'place_id' => $place->id,
                'image_url' => $path,
            ]);
        }
    }

    return redirect()->route('places.index')->with('success', 'Place updated');
}

public function destroy(Places $place)
{
    $place->delete();
    return back()->with('success', 'Place deleted');
}

public function toggleStatus(Places $place)
{
    $place->update(['is_active' => !$place->is_active]);
    return back()->with('success', 'Status updated');
}
public function photos(Places $place)
{
    $photos = $place->photos;
    return view('admin.places.photos', compact('place', 'photos'));
}

public function deletePhoto(PlacePhoto $photo)
{
    Storage::disk('public')->delete($photo->image_url);
    $photo->delete();
    return back()->with('success', 'Photo deleted');
}
public function setPrimaryPhoto(PlacePhoto $photo)
{
    $photo->place->photos()->update(['is_primary' => false]);
    $photo->update(['is_primary' => true]);
    return back()->with('success', 'Primary photo updated');
}
public function uploadPhotos(Request $request, Places $place)
{
    $request->validate([
        'photos.*' => 'required|image|max:2048',
    ]);

    foreach ($request->file('photos') as $index => $photo) {
        $path = $photo->store('place_photos', 'public');
        $place->photos()->create([
            'image_url' => $path,
            'is_primary' => false
        ]);
    }

    return back()->with('success', 'Photos uploaded successfully');
}

public function search(Request $request)
{
    $q = $request->query('search');
    $places = Places::when($q, fn($qry) => 
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%"))
            ->limit(20)
            ->get(['id','name','type','latitude','longitude','thumbnail_image']);

    return response()->json($places);
}


}
