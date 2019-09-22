<?php

use Illuminate\Console\Command;
use App\Http\Controllers\HelperTrait;
use App\Order;
use App\Tasting;

class CronMethods extends Command
{
    use HelperTrait;

    public function checkOrders()
    {
        $orders = Order::where('status',1)->get();
        foreach ($orders as $order) {
            if ($order->lead_time <= time()) {
                $order->status = 2;
                $order->save();
            }
        }
    }

    public function checkTasting()
    {
        $tastings = Tasting::where('active',1)->get();
        foreach ($tastings as $tasting) {
            if ($tasting->lead_time <= time()) {
                $tasting->active = 0;
                $tasting->save();
            }
        }
    }
}