<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'barcode',
        'category_id',
        'brand_id',
        'unit_sale',
        'unit_purchas',
        'inputprice',
        'outputprice',
        'quantity',
        'discountpercen',
        'stock_alert',
        'status'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function product()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }
}
