<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PreorderCreated;
use App\Notifications\Preorder;
use App\Models\User;

class PreorderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PreorderCreated $event
     * @return void
     */
    public function handle(PreorderCreated $event)
    {
        // отправка уведомления клиенту
        $event->order->user->notify(new Preorder($event->order));
        // отправка уведомления менеджеру
        $manager = User::where('email', (string)Settings::getSettings()->email)->first();
        $manager->notify(new Preorder($event->order));

    }
}
