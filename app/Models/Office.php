<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasting;

class Office extends Model
{
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    /**
     * Список всех офисов
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getOffices()
    {
        return Cache::remember('ofices', $seconds = 60 * 60 * 24, function() {
            return self::all();
        });
    }

    public function tastings()
    {
        return $this->hasMany(Tasting::class);
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
