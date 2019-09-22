<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToTasting extends Model
{
    protected $fillable = [
        'user_id',
        'tasting_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tasting()
    {
        return $this->belongsTo('App\Tasting');
    }

    public $timestamps = false;
}