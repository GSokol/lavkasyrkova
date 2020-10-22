<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\User;

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

    public static function getUserTasting(User $user)
    {
        return Tasting::where('office_id', $user->office_id)
            ->where('time', '>', time() + (60 * 60 * 5))
            ->where('active', 1)
            ->orderBy('time', 'desc')
            ->get();
    }
}
