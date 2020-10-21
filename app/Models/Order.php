<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Models\ProductToOrder;
use App\Models\Store;
use App\Models\Tasting;

class Order extends Model
{
    protected $fillable = [
        'status_id',
        'description',
        'user_id',
        'tasting_id',
        'shop_id',
        'delivery',
        'discount_value',
    ];

    /**
     * Сумма заказа (чистая. без учета скидок и вычетов)
     *
     * @return int
     */
    public function getTotalAmountAttribute(): int {
        return $this->orderToProducts->sum(function($orderProduct) {
            return $orderProduct->amount;
        });
    }

    /**
     * Размер скидки в деньгах
     *
     * @return int
     */
    public function getDiscountAmountAttribute(): int {
        if ($this->discount_value) {
            return $this->discount_value * $this->total_amount / 100;
        }
        return 0;
    }

    /**
     * Итоговая сумма заказа (с учетом скидок и вычетов)
     *
     * @return int
     */
    public function getCheckoutAmountAttribute(): int {
        return $this->total_amount - $this->discount_amount;
    }

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
        return $this->belongsTo(Tasting::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Статус заказа
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
