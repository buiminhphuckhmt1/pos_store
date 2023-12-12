<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id', 'qty','cost','price','code'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected $casts = [
        'product_id' => 'integer',
        'qty' => 'double',
        'cost' => 'double',
        'price' => 'double',
    ];

}
