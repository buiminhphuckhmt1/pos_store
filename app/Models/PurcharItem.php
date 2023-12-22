<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurcharItem extends Model
{
    protected $fillable =[
        'cost',
        'quantity',
        'product_id',
        'purchar_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
