<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductToOrder;
use App\Models\Store;

class Order extends Model
{
    protected $fillable = [
        'status',
        'status_id',
        'description',
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
        return $this->hasMany(ProductToOrder::class);
    }

    public function tasting()
    {
        return $this->belongsTo('App\Tasting');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
