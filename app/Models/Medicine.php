<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PharmaceuticalCompanies;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'status',
        'category_id',
        'company_id', 
        'description',
        'image',
    ];

    
    public function company()
    {
        return $this->belongsTo(PharmaceuticalCompanies::class, 'company_id');
    }

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // في نموذج Medicine
public function pharmaceuticalCompany()
{
    return $this->belongsTo(PharmaceuticalCompany::class, 'company_id'); 
}
}