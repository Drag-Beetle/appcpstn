<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Places extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'website',
        'business_hours',
        'latitude',
        'longitude',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(PlacePhoto::class, 'place_id');
    }
    public function reviews(){
        return $this->hasMany(PlaceReview::class , 'place_id');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
