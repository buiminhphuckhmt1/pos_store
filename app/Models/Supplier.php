<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model

{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        "name",'phone','country','user_id',
    ];
    public function getUserName()
    {
        if($this->users) {
            return $this->users->last_name;
        }
        return 'k';
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



}
