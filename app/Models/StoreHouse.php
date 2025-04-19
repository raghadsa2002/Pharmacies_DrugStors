<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StoreHouse extends Authenticatable
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'status',
        'city',
        'address',
        'password',
        'email',
        'created_by',
    ];
    //علاقة المستودعات مع المدير

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function orders()
{
    return $this->hasMany(Order::class);
}

public function offers()
{
    return $this->hasMany(Offer::class, 'store_houses_id');
}

}
