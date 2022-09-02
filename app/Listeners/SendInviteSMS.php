<?php

namespace App\Listeners;

use App\Events\VisitCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInviteSMS
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
     * @param  VisitCreatedEvent  $event
     * @return void
     */
    public function handle(VisitCreatedEvent $event)
    {
        //
    }
}
