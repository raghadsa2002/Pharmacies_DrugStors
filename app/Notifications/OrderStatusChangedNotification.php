<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    protected $orderId;
    protected $newStatus;

    public function __construct($orderId, $newStatus)
    {
        $this->orderId = $orderId;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Order Status Updated',
            'body' => "Your order #{$this->orderId} status has been changed to {$this->newStatus}.",
        ];
    }
}