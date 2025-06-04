<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacy;
use App\Models\StoreHouse;
use App\Models\Offer;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

   protected $fillable = [
    'pharmacy_id',
    'store_houses_id',
    'status',
    'total_price',
    'offer_id', // ← لازم تكون هنا
];
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function storehouse()
    {
        return $this->belongsTo(StoreHouse::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}