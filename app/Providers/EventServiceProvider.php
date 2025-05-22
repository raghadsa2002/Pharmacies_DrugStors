<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewOrderEvent;
use App\Listeners\NotifyNewOrder;
use App\Events\LowStockEvent;
use App\Listeners\NotifyLowStock;
use App\Events\NewOfferEvent;
use App\Listeners\NotifyNewOffer;
use App\Events\OrderStatusChangedEvent;
use App\Listeners\NotifyOrderStatusChanged;
 
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // ربط الأحداث بالـ Listeners
        NewOrderEvent::class => [
            NotifyNewOrder::class,
        ],
        LowStockEvent::class => [
            NotifyLowStock::class,
        ],
        NewOfferEvent::class => [
            NotifyNewOffer::class,
        ],
        OrderStatusChangedEvent::class => [
            NotifyOrderStatusChanged::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}