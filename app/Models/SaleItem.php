<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    // Link to Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Optionally, link to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
