<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\VisitCreatedEvent' => [
            'App\Listeners\SendInviteEmail',
            'App\Listeners\SendInviteSMS',
        ],

        'App\Events\VisitUpdatedEvent' => [
            'App\Listeners\ReSendInviteEmail',
            'App\Listeners\ReSendInviteSMS',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
