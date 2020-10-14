<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class AddCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
