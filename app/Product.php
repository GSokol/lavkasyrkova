<?php

namespace App;

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

    public function productToActions()
    {
        return $this->hasMany('App\ActionsToProduct');
    }
}
