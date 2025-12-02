<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'image',
        // 'sku',
        'name',
        // 'description',
        'price',
        'quantity',
    ];

public function category() { return $this->belongsTo(Category::class); }
public function stockMovements() { return $this->hasMany(StockMovement::class); }
public function saleItems() { return $this->hasMany(SaleItem::class); }

}


