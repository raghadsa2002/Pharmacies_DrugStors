<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pharmacy extends Authenticatable
{
    use HasFactory, Notifiable , SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'phone',
        'city',
        'address',
        'img',
        'created_by',
    ];

     //علاقة الصيدليات مع المدير

     public function admin()
     {
         return $this->belongsTo(Admin::class, 'created_by');
     }
    public function orders()
    {
        return $this->hasMany(Order::class);
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
