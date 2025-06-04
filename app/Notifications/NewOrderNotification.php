<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database']; // نحفظه في قاعدة البيانات
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Order Received',
            'body' => 'A new order has been placed by pharmacy: ' . $this->order->pharmacy->name,
            'order_id' => $this->order->id,
        ];
    }
}