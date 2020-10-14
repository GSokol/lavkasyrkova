<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Store extends Model
{
    protected $table = 'shops';

    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
