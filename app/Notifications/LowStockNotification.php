<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $medicine;

    public function __construct($medicine)
    {
        $this->medicine = $medicine;
    }

    public function via($notifiable)
    {
        return ['database']; // تخزينها في قاعدة البيانات
    }

    public function toDatabase($notifiable)
    {
        return [
            'medicine_id' => $this->medicine->id,
            'medicine_name' => $this->medicine->name,
            'stock' => $this->medicine->stock,
            'message' => "Stock for medicine {$this->medicine->name} is low ({$this->medicine->stock} units).",
             'title' => 'Low Stock Alert',
        'body' => 'The stock for Paracetamol is below minimum!',
        ];
    }
}