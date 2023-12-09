<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function order_item()
    {
        return $this->belongsTo(OrderItem::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getCustomerName()
    {
        if($this->customer) {
            return $this->customer->last_name;
        }
        return 'Khách vãng lai';
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
    public function getCustomerAddress()
    {
        if($this->customer) {
            return $this->customer->address;
        }
        return '';
    }
    public function getCustomerPhone()
    {
        if($this->customer) {
            return $this->customer->phone;
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
