<?php

use Illuminate\Console\Command;
use App\Http\Controllers\HelperTrait;
use App\Order;
use App\Tasting;

class CronMethods extends Command
{
    use HelperTrait;

    public function checkTasting()
    {
//        $tastingsIds = [];
//        $ordersIds = [];
        $tastings = Tasting::where('active',1)->get();
        foreach ($tastings as $tasting) {
            if ($tasting->time < time()) {
                foreach ($tasting->orders as $order) {
                    if ($order->status == 1) {
//                        $ordersIds[] = $order->id;
                        $order->status = 2;
                        $order->save();
                    }
                }
//                $tastingsIds[] = $tasting->id;
                $tasting->active = 0;
                $tasting->save();
            }
        }

//        if (count($tastingsIds)) {
//            $this->sendMessage('romis.nesmelov@gmail.com', 'auth.emails.tasting_admin_informing', [
//                'tastings' => $tastingsIds,
//                'orders' => $ordersIds
//            ]);
//        }
    }
    
    public function informingAboutTastings()
    {
        $tastings = Tasting::where('time','<',(time() + (60 * 60 * 24 * 3)))->where('active',1)->where('informed',0)->get();
        foreach ($tastings as $tasting) {
            foreach ($tasting->office->users as $user) {
                if ($user->send_mail) {
                    $this->sendMessage($user->email,'auth.emails.tasting_informing', [
                        'address' => $tasting->office->address,
                        'time' => date('d.m.Y',$tasting->time)
                    ]);
                }
            }
            $tasting->informed = 1;
            $tasting->save();
        }
    }
    
    public function cronInforming()
    {
        $this->sendMessage('romis.nesmelov@gmail.com', 'auth.emails.cron_informing', []);
    }
}