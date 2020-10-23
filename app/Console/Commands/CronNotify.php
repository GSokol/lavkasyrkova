<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\HelperTrait;

class CronNotify extends Command
{
    use HelperTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily notification about success cron job';

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
            $this->notify();
            $this->info('Success notify informing about cron job');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function notify()
    {
        $this->sendMessage('romis.nesmelov@gmail.com', 'emails.cron_informing', []);
    }
}
