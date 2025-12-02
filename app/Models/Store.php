<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function stockMovements() { return $this->hasMany(StockMovement::class); }
//
}
