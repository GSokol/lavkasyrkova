<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductToOrder extends Model
{
    protected $fillable = [
        'whole_value',
        'part_value',
        'product_id',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public $timestamps = false;
}