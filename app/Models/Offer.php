<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'image',
        'store_houses_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OfferItem::class);
    }


    public function storehouse()
{
    return $this->belongsTo(Storehouse::class, 'store_houses_id'); // اسم العمود قد يختلف عندك، تأكدي منه
}

public function offer_items()
{
    return $this->hasMany(OfferItem::class);
}
// App\Models\Offer.php
public function orders()
{
    return $this->hasMany(Order::class);
}
}