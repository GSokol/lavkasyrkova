<?php

namespace App;

use App\Ticket;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'name', 'phone', 'address', 'password', 'confirm_token', 'active', 'is_admin', 'send_mail', 'office_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function office()
    {
        return $this->belongsTo('App\Office');
    }
    
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function userToTastings()
    {
        return $this->hasMany('App\UserToTasting');
    }
}
