<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewOfferNotification extends Notification
{
    use Queueable;

    protected $offerTitle;

    public function __construct($offerTitle)
    {
        $this->offerTitle = $offerTitle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Offer Available!',
            'body' => 'A new offer "' . $this->offerTitle . '" has been added. Check it out!',
        ];
    }
}