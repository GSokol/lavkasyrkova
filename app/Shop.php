<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}