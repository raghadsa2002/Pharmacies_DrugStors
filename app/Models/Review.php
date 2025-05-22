<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['order_id', 'pharmacy_id', 'rating', 'comment'];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function pharmacy() {
        return $this->belongsTo(Pharmacy::class);
    }
}