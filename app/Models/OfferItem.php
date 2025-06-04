<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferItem extends Model
{
    protected $fillable = ['offer_id', 'medicine_id', 'type', 'value', 'required_quantity'];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}