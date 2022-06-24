<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HelperTrait;
use App\Models\Order;
use App\Models\Product;

class ProductToOrder extends Model
{
    use HelperTrait;

    public $timestamps = false;

    protected $fillable = [
        'whole_value',
        'part_value',
        'actual_value',
        'product_id',
        'order_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['amount', 'quantity_unit'];

    /**
     * Количество с единицами измерения
     *
     * @return string
     */
    public function getQuantityUnitAttribute(): string {
        return $this->whole_value ? $this->whole_value . ' шт.' : $this->part_value . ' г.';
    }

    /**
     * Стоимость товара в заказе с учетом количества/веса
     *
     * @return string
     */
    public function getAmountAttribute() {
        // целое количество
        if ($this->whole_value) {
            $wholePrice = $this->product->action ? $this->product->action_whole_price : $this->product->whole_price;
            return $this->whole_value * $wholePrice;
        }
        // на вес
        $price = $this->product->action ? $this->product->action_part_price : $this->product->part_price;
        $weight = $this->actual_value ?: $this->part_value;
        return round($weight / $this->productParts[0] * $price);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
