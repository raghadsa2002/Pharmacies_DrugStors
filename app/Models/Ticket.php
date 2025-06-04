<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['order_id', 'storehouse_id', 'pharmacy_id', 'message', 'status'];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function storehouse() {
        return $this->belongsTo(Storehouse::class);
    }

    public function pharmacy() {
        return $this->belongsTo(Pharmacy::class);
    }
    public function messages()
{
    return $this->hasMany(Message::class);
}

    



}