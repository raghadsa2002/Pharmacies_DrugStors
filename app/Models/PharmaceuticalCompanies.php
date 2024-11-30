<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PharmaceuticalCompanies;


class PharmaceuticalCompanies extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'status',
        'city',
        'address',
        'created_by',
    ];

   
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    
    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'pharmaceutical_company_id');
    }
}