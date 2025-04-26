<?php

namespace App\Http\Controllers;

use App\Models\Places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MapController extends Controller
{
    public function getMapData()
    {
        // Eager-load photos for each place
        $places = Places::with('photos')->get();
        
        $features = $places->map(function($place) {
            // Extract all image URLs from the related photos
            $imageUrls = $place->photos
    ->map(fn($photo) => URL::to($photo->url))
    ->toArray();

            return [
                'type' => 'Feature',
                'id' => $place->id,
                'geometry' => [
                    'type' => 'Point',
                    // GeoJSON expects [longitude, latitude]
                    'coordinates' => [(float)$place->longitude, (float)$place->latitude],
                ],
                'properties' => [
                    'name' => $place->name,
                    'description' => $place->description,
                    'type' => $place->type,
                    'images' => $imageUrls, // Include images array here
                ],
            ];
        })->toArray();

        $data = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        return response()->json($data);
    } 
    
}




//Hardcoded Data below for reference
/*
// Example GeoJSON data
        $data = [
            "type" => "FeatureCollection",
            "features" => [
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2472, 9.1926], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "Dauin Restaurant",
                        "description" => "A popular restaurant in Dauin serving local delicacies.",
                        "type" => "restaurant",
                    ],
                ],
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2450, 9.1950], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "St. Augustine Church",
                        "description" => "A historical church in Dauin.",
                        "type" => "church",
                    ],
                ],
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2490, 9.1910], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "Dauin Public Market",
                        "description" => "A bustling market offering fresh produce and local goods.",
                        "type" => "market",
                    ],
                ],
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2480, 9.1930], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "Dauin Port",
                        "description" => "A small port for local fishermen and boats.",
                        "type" => "park",
                    ],
                ],
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2480, 9.1990], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "Dauin Port",
                        "description" => "A small port for local fishermen and boats.",
                        "type" => "park",
                    ],
                ],
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2480, 9.1980], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "Dauin Port",
                        "description" => "A small port for local fishermen and boats.",
                        "type" => "park",
                    ],
                ],
                [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [123.2472, 9.1950], // Dauin coordinates
                    ],
                    "properties" => [
                        "name" => "Market Above User Location ",
                        "description" => "A bustling market offering fresh produce and local goods.",
                        "type" => "market",
                    ],
                ],
            ],
        ];
    
        return response()->json($data);
*/