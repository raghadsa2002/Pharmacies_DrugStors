<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description',
        'manufacturer',
        'status',
        'stock',
        'image',
    ];

    public function category()
{
    return $this->belongsTo(Category::class);
}
}