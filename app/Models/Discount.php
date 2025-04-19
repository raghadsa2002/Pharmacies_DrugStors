<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{protected $fillable = ['medicine_id', 'discounted_price',];
    // في موديل Discount
public function medicine()
{
    return $this->belongsTo(Medicine::class);
}



}
