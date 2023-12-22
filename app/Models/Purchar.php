<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchar extends Model
{
    protected $fillable = [
        'supplier_id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(PurcharItem::class);
    }

    public function paymentpurs()
    {
        return $this->hasMany(Paymentpur::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchar_item()
    {
        return $this->belongsTo(PurcharItem::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getSupplierName()
    {
        if($this->supplier) {
            return $this->supplier->name;
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
            return $i->cost;
        })->sum();
    }

    public function formattedTotal()
    {
        return number_format($this->total());
    }

    public function receivedAmount()
    {
        return $this->paymentpurs->map(function ($i){
            return $i->amount;
        })->sum();
    }
    public function receivedDiscount()
    {
        return $this->paymentpurs->map(function ($i){
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
