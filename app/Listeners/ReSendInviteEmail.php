<?php

namespace App\Listeners;

use App\Events\VisitUpdatedEvent;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class ReSendInviteEmail /*implements ShouldQueue*/
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
        $to=$event->visit->email;
        $from=Config::get('mail.from.address');
        $subject='Resend Invite Email';
        $data=$event->visit;
        $view='emails.invite_mail';
        Mail::to($to)->send(new SendMail($from,$subject,$data,$view));
    }
}
