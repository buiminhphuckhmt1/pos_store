<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'image',
        'name'
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

}
