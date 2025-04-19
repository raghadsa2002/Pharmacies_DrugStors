<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'store_houses_id',
        'medicine_id_1',
        'medicine_id_2',
        'discount_price',
        'start_date',
        'end_date',
    ];

    public function medicine1()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id_1');
    }

    public function medicine2()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id_2');
    }

    public function storehouse()
    {
        return $this->belongsTo(StoreHouse::class, 'store_houses_id');
    }

    // إضافة علاقة الطلبات
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}