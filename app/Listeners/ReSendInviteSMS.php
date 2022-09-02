<?php

namespace App\Listeners;

use App\Events\VisitUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReSendInviteSMS
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
     * @param  VisitUpdatedEvent  $event
     * @return void
     */
    public function handle(VisitUpdatedEvent $event)
    {
        //
    }
}
