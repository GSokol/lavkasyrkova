<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tasting;

class CronInformTasting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:inform-tasting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily information about tasting';

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
            $this->informingAboutTastings();
            $this->info('Success informing about tasting');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function informingAboutTastings()
    {
        $tastings = Tasting::where('time', '<', time() + (60 * 60 * 24 * 3))
            ->where('active', 1)
            ->where('informed', 0)
            ->get();
        foreach ($tastings as $tasting) {
            foreach ($tasting->office->users as $user) {
                if ($user->send_mail) {
                    $this->sendMessage($user->email, 'auth.emails.tasting_informing', [
                        'address' => $tasting->office->address,
                        'time' => date('d.m.Y',$tasting->time)
                    ]);
                }
            }
            $tasting->informed = 1;
            $tasting->save();
        }
        return true;
    }
}
