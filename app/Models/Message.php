<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'pharmacy_id', 'storehouse_id', 'message'];

    public function ticket()
{
    return $this->belongsTo(Ticket::class);
}
}
