<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class ProductToOrder extends Model
{
    public $timestamps = false;

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
        return $this->belongsTo(Order::class);
    }
}
