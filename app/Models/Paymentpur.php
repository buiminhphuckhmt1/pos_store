<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymentpur extends Model
{
    protected $fillable = [
        'amount',
        'discount',
        'purchar_id',
        'user_id',
    ];
    public function purchar()
    {
        return $this->belongsTo(Purchar::class);
    }
}
