<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToTasting extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tasting_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tasting()
    {
        return $this->belongsTo('App\Models\Tasting');
    }
}
