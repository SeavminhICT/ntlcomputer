<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_code',
        'brand',
        'model',
        'cpu',
        'ram',
        'storage',
        'gpu',
        'display',
        'color',
        'condition',
        'warranty',
        'country',
        'price',
        'stock',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'price' => 'decimal:2',
    ];

    public static function generateCode(string $prefix = 'PRD'): string
    {
        return strtoupper($prefix).'-'.Str::upper(Str::random(6));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
