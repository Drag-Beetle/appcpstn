<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PlacePhoto extends Model
{
    protected $table = 'place_photos';
    protected $fillable = ['place_id', 'image_url', 'caption', 'is_primary'];

    public function place()
    {
       return $this->belongsTo(Places::class);
    }
    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->image_url);
    }
}
