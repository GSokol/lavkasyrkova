<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'user_id',
        'tasting_id',
        'shop_id',
        'delivery',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orderToProducts()
    {
        return $this->hasMany('App\ProductToOrder');
    }

    public function tasting()
    {
        return $this->belongsTo('App\Tasting');
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}