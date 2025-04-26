<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceReview extends Model
{
    protected $fillable= [
        'place_id', 'user_id', 'rating', 'comment','created_at', 'updated_at',
    ];

    public function place(){
        return $this->belongsTo(Places::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
