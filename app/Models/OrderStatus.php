<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const ORDER_STATUS_NEW = 'new';
    const ORDER_STATUS_PICKED = 'picked';
    const ORDER_STATUS_DONE = 'done';
    const ORDER_STATUS_CANCELED = 'canceled';

    protected $table = 'order_status';

    protected $fillable = [
        'code',
        'name',
        'class_name',
    ];

    /**
     * scope code
     * 
     * @param  [type] $query [description]
     * @param  [type] $code  [description]
     * @return [type]        [description]
     */
    public function scopeCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
