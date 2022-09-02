<?php

namespace App\Listeners;

use App\Events\VisitCreatedEvent;
use App\Mail\SendAttachMail;
use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class SendInviteEmail /*implements ShouldQueue*/
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
        $to=$event->visit->email;
        $from=Config::get('mail.from.address');
        $subject='Invite Email';
        $data=$event->visit;
        $view='emails.invite_mail';

        $calendar= Calendar::create('Meeting with '.$event->visit->user->name)
            ->event(Event::create(ucfirst($event->visit->purpose->name).' Meeting with '.$event->visit->user->name)
                ->organizer($event->visit->user->email, $event->visit->user->name)
                ->createdAt($event->visit->created_at)
                ->startsAt(Carbon::createFromFormat('Y-m-d H:i',$event->visit->date.''.$event->visit->time))
                ->endsAt(Carbon::createFromFormat('Y-m-d H:i',$event->visit->date.''.$event->visit->time)->addHour())
                ->alertMinutesBefore(5, 'Your Meeting is going to start in five mintutes')
            )
            ->get();
        Mail::to($to)->send(new SendAttachMail($from,$subject,$data,$view,$calendar));
    }
}
