<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmaceuticalCompanies extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'status',
        'city',
        'address',
        'created_by',
    ];

     //علاقة شركات الادوية مع المدير

     public function admin()
     {
         return $this->belongsTo(Admin::class, 'created_by');
     }
}
