<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',       // matches migration
        'customer_id',        // matches migration
        'subtotal',
        'tax',
        'shipping',
        'total',
        'status',
        'delivery_address'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
