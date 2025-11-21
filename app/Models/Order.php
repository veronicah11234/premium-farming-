<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name','customer_phone','delivery_address','delivery_date','status','total'
    ];

    protected $dates = ['delivery_date'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
