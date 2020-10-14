<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    /**
     * Товары категории
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
