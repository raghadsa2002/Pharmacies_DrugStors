<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pharmacy;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_id',
        'store_houses_id',
        'offer_id',
        'medicine_id',
        'medicine_id_1',
        'medicine_id_2',
        'quantity',
        'status',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

   
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id'); 
    }

    public function storehouse()
{
    return $this->belongsTo(StoreHouse::class);
}

public function offer()
{
    return $this->belongsTo(Offer::class);
}

public function medicine1()
{
    return $this->belongsTo(Medicine::class, 'medicine_id_1');
}

public function medicine2()
{
    return $this->belongsTo(Medicine::class, 'medicine_id_2');
}
}