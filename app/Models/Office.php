<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasting;

class Office extends Model
{
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    public function tastings()
    {
        return $this->hasMany(Tasting::class);
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
