<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Office;
use App\Models\Order;
use App\Models\UserToTasting;
use App\Ticket;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'name',
        'phone',
        'address',
        'password',
        'confirm_token',
        'active',
        'is_admin',
        'send_mail',
        'office_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function userToTastings()
    {
        return $this->hasMany(UserToTasting::class);
    }
}
