<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\ProductToOrder;

class Product extends Model
{
    protected $fillable = [
        'name',
        'additionally',
        'description',
        'image',
        'big_image',
        'parts',
        'whole_price',
        'whole_weight',
        'part_price',
        'action_whole_price',
        'action_part_price',
        'new',
        'action',
        'active',
        'category_id',
        'add_category_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parts' => 'boolean',
        'active' => 'boolean',
        'new' => 'boolean',
        'action' => 'boolean',
    ];

    /**
     * Изображение товара
     *
     * @return string
     */
    public function getImageAttribute($value): string {
        if (!file_exists(public_path($value))) {
            return '/images/default.jpg';
        }
        return $value;
    }

    /**
     * Изображение товара
     *
     * @return string
     */
    public function getBigImageAttribute($value): string {
        if (!file_exists(public_path($value))) {
            return '/images/default.jpg';
        }
        return $value;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addCategory()
    {
        return $this->belongsTo(AddCategory::class);
    }

    public function productToOrders()
    {
        return $this->hasMany(ProductToOrder::class);
    }

    public static function getActions()
    {
        return static::where(function($query) {
            $query->where('action', 1)->orWhere('new', 1);
        })->where('active', 1)->get();
    }
}
