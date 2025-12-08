<?php


// Category Model (Laravel Eloquent)
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
use HasFactory;


protected $fillable = [
'name',
'slug',
'description',
'image',
];


public function feeds()
{
return $this->hasMany(Feed::class);
}
}
