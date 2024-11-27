<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'gender',
        'age',
        'phone',
        'address',
        'img',
    ];


    //علاقة المدير مع الصيدليات

    public function pharmacy()
    {
        return $this->hasMany(Pharmacy::class, 'created_by');
    }

    //علاقة المدير مع المستودعات

    public function storeHouse()
    {
        return $this->hasMany(StoreHouse::class, 'created_by');
    }

     //علاقة المدير مع شركات الادروية

     public function pharmaceuticalCompanies()
     {
         return $this->hasMany(StoreHouse::class, 'created_by');
     }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
