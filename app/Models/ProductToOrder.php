<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HelperTrait;
use App\Models\Order;

class ProductToOrder extends Model
{
    use HelperTrait;

    public $timestamps = false;

    protected $fillable = [
        'whole_value',
        'part_value',
        'product_id',
        'order_id',
    ];

    /**
     * Количество с единицами измерения
     *
     * @return string
     */
    public function getQuantityUnitAttribute(): string {
        return $this->whole_value ? $this->whole_value . ' шт.' : $this->part_value . ' г.';
    }

    /**
     * Стоимость товара в заказе с учетом количества
     *
     * @return string
     */
    public function getAmountAttribute() {
        if ($this->whole_value) {
            $wholePrice = $this->product->action ? $this->product->action_whole_price : $this->product->whole_price;
            return $this->whole_value * $wholePrice;
        }
        $price = $this->product->action ? $this->product->action_part_price : $this->product->part_price;
        return ceil($this->part_value / $this->productParts[0] * $price);
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
