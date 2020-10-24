<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Store extends Model
{
    protected $table = 'shops';

    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    /**
     * Список всех магазинов
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getStores()
    {
        return Cache::remember('stores', $seconds = 60 * 60 * 12, function() {
            return self::all();
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
