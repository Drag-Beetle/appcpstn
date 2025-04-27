<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/map', function () {
    return view('mapTest');});
require __DIR__.'/auth.php';


//admin

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/places', [PlaceController::class, 'index'])->name('admin.places');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');    
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::get('/create', [PlaceController::class, 'create'])->name('admin.create');
    Route::get('/edit/{place}', [PlaceController::class, 'edit'])->name('places.edit');
    Route::put('/edit/{place}', [PlaceController::class, 'update'])->name('places.update');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('admin.users.toggle');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/users/bulk', [UserController::class, 'bulk'])->name('admin.users.bulk');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');


    Route::resource('places', PlaceController::class)->except(['show']);
    Route::patch('/places/{place}/toggle', [PlaceController::class, 'toggleStatus'])->name('places.toggle');
    Route::get('/places/{place}/photos', [PlaceController::class, 'photos'])->name('places.photos');
Route::delete('/places/photos/{photo}', [PlaceController::class, 'deletePhoto'])->name('places.photos.delete');
Route::patch('/places/photos/{photo}/primary', [PlaceController::class, 'setPrimaryPhoto'])->name('places.photos.primary');
Route::post('/places/{place}/photos', [PlaceController::class, 'uploadPhotos'])->name('places.photos.upload');

});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// FOR REVIEW PAGE
Route::get('/admin/reviews/create', function () {
    return view('admin.reviews.create', [
        'places' => \App\Models\Places::all()
    ]);
})->name('admin.reviews.create');
Route::post('/admin/notifications/mark-all-read', action: [ActivityLogController::class, 'markAllRead'])->name('admin.notifications.markAllRead');

Route::post('/admin/reviews', [ReviewController::class, 'store'])->name('admin.reviews.store');
//Admmin.Settings
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

//search admin
Route::get('/admin/search', [SearchController::class, 'index'])->name('admin.search');


//Profile
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

});


// Route::get('/dashboard', [DashboardController::class, 'dashboard'])
//     ->middleware(['auth'])
//     ->name('dashboard');