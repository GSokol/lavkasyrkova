<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    public function tastings()
    {
        return $this->hasMany('App\Tasting')->orderBy('id','desc');
    }
}