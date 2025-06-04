<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountNotification extends Notification
{
    use Queueable;
    protected $medicine;

    /**
     * Create a new notification instance.
     */
    public function __construct($medicine)
    {
        //
        $this->medicine = $medicine;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($object)
    {
        return [
            'title' => 'New Discount',
            'body' => 'medicane' . $this->medicine->title . 'has discount' ,
            'medicine_id' => $this->medicine->id
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
