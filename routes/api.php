<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('sample', [AuthController::class, 'sample']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/scheduled', [BookingController::class, 'show']);

});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('map-data', [MapController::class, 'getMapData']);
Route::get('/places', [PlaceController::class, 'show']);


Route::post('/review', [ReviewApiController::class, 'store']);