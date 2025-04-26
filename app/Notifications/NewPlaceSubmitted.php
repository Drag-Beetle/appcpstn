<?php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewPlaceSubmitted extends Notification
{
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Place Submitted',
            'message' => $this->place->name . ' was submitted for approval.',
            'place_id' => $this->place->id,
            'url' => route('places.edit', $this->place->id), // <<< ADD THIS LINE
        ];
    }

    public function __construct(public \App\Models\Places $place) {}
}
