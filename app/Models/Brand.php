<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'image',
        'name'
    ];
    public function products()
    {
        return $this->hasMany(Post::class, 'brand_id', 'id');
    }

}
