<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Tasting extends Model
{
    protected $fillable = [
        'time',
        'active',
        'informed',
        'office_id'
    ];

    public function office()
    {
        return $this->belongsTo('App\Office');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tastingToUsers()
    {
        return $this->hasMany('App\UserToTasting');
    }
}
