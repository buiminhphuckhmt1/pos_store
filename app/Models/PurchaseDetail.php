<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable =[
        'price',
        'cost',
        'quantity',
        'product_id',
        'supplier_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
