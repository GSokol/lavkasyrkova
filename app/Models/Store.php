<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Store extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * List of all stores
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getStores()
    {
        return Cache::remember('stores', $seconds = 60 * 60 * 12, function() {
            return self::all()->map(function($store) {
                return [
                    'id' => $store->id,
                    'address' => $store->address,
                    'coords' => [
                        'latitude' => $store->latitude,
                        'longitude' => $store->longitude,
                    ],
                ];
            });
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
