<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\PlaceReview;

class NewReviewSubmitted extends Notification
{
    use Queueable;

    public function __construct(public PlaceReview $review) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Review Posted',
            'message' => $this->review->user->name . ' left a review on ' . $this->review->place->name,
            'rating' => $this->review->rating,
            'review_id' => $this->review->id,
            'place_id' => $this->review->place_id,
            'url' => route('admin.reviews.index'),
        ];
    }
}
