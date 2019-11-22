<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'big_image',
        'parts',
        'whole_price',
        'whole_weight',
        'part_price',
        'action_whole_price',
        'action_part_price',
        'action',
        'active',
        'category_id',
        'add_category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function addCategory()
    {
        return $this->belongsTo('App\AddCategory');
    }
    
    public function productToOrders()
    {
        return $this->hasMany('App\ProductToOrder');
    }

    public function productToActions()
    {
        return $this->hasMany('App\ActionsToProduct');
    }
}