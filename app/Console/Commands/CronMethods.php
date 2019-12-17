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
    
    public function informingAboutTastings()
    {
        $tastings = Tasting::where('time','>',time())->where('time','<',(time() + (60 * 60 * 24 * 3)))->where('active',1)->where('informed',NULL)->get();
        foreach ($tastings as $tasting) {
            foreach ($tasting->office->users as $user) {
                if ($user->send_mail) {
                    $this->sendMessage('romis.nesmelov@gmail.com', 'auth.emails.tasting_informing', [
                        'address' => $tasting->office->address,
                        'time' => date('d.m.Y',$tasting->time)
                    ]);
                }
            }
        }
    }
}