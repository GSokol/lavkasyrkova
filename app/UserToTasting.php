<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasting;

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
        return $this->belongsTo(Tasting::class);
    }

    public $timestamps = false;
}
