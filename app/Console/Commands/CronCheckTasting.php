<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderStatus;
use App\Models\Tasting;

class CronCheckTasting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:check-tasting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily check new tasting';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->checkTasting();
            $this->info('Success check tasting');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function checkTasting()
    {
        $tastingsIds = [];
        $ordersIds = [];
        $tastings = Tasting::where('active', 1)->get();
        $statusNew = OrderStatus::code(OrderStatus::ORDER_STATUS_NEW)->first();
        $statusDone = OrderStatus::code(OrderStatus::ORDER_STATUS_DONE)->first();

        foreach ($tastings as $tasting) {
            if ($tasting->time < time()) {
                foreach ($tasting->orders as $order) {
                    if ($order->status_id == $statusNew->id) {
                       $ordersIds[] = $order->id;
                        $order->status_id = $statusDone->id;
                        $order->save();
                    }
                }
               $tastingsIds[] = $tasting->id;
                $tasting->active = 0;
                $tasting->save();
            }
        }

       // if (count($tastingsIds)) {
       //     $this->sendMessage('romis.nesmelov@gmail.com', 'emails.tasting_admin_informing', [
       //         'tastings' => $tastingsIds,
       //         'orders' => $ordersIds
       //     ]);
       // }

       return true;
    }
}
