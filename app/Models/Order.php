<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Models\ProductToOrder;
use App\Models\Store;
use App\Models\Tasting;

class Order extends Model
{
    const PAYMENT_TYPE_CARD = 'card';
    const PAYMENT_TYPE_CASH = 'cash';
    const PAYMENT_TYPES = [
        self::PAYMENT_TYPE_CARD,
        self::PAYMENT_TYPE_CASH,
    ];

    protected $fillable = [
        'status_id',
        'description',
        'user_id',
        'tasting_id',
        'shop_id',
        'delivery',
        'payment_type',
        'discount_value',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total_amount'];

    /**
     * Дата создания заказа (форматированная)
     *
     * @return string
     */
    public function getCreatedAtAttribute($value): string {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

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

    /**
     * Информация о доставке
     *
     * @return string
     */
    public function getDeliveryInfoAttribute(): string {
        if ($this->delivery) {
            return 'по адресу: ' . $this->user->address;
        }
        if ($this->shop_id) {
            return 'в магазин: ' . $this->store->address;
        }
        if ($this->user->office->id > 2) {
            return 'в офис: ' . $this->user->office->address;
        }
        return $this->user->office->address;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
        return $this->belongsTo(Store::class, 'shop_id');
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
