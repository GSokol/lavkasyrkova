<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany('App\Order');
    }
    
    public function tastingToUsers()
    {
        return $this->hasMany('App\UserToTasting');
    }
}