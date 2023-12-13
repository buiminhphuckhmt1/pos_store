<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purcha extends Model
{
    protected $fillable = [
        'suppler_id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purcha_item()
    {
        return $this->belongsTo(PurchaItem::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
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
    public function getSupplierAddress()
    {
        if($this->supplier) {
            return $this->supplier->address;
        }
        return '';
    }
    public function getSupplierPhone()
    {
        if($this->supplier) {
            return $this->supplier->phone;
        }
        return '';
    }
    public function total()
    {
        return $this->items->map(function ($i){
            return $i->price;
        })->sum();
    }

    public function formattedTotal()
    {
        return number_format($this->total());
    }

    public function receivedAmount()
    {
        return $this->payments->map(function ($i){
            return $i->amount;
        })->sum();
    }
    public function receivedDiscount()
    {
        return $this->payments->map(function ($i){
            return $i->discount;
        })->sum();
    }
    public function formattedReceivedDiscount()
    {
        return number_format($this->receivedDiscount());
    }
    public function formattedReceivedAmount()
    {
        return number_format($this->receivedAmount());
    }
}
