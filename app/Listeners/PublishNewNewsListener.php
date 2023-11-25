<?php

namespace App\Listeners;

use App\Events\PublishNewNewsEvent;
use App\Models\User;
use App\Notifications\NewNewsMailNotification;
use App\Service\BaseCodeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

//use Illuminate\Notifications\Notification;

class PublishNewNewsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly BaseCodeService $service)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PublishNewNewsEvent $event): void
    {
        $service = new BaseCodeService();
        $logoImg = $service->encodeLogoMail();

        User::chunk(500, function ($users) use($event, $logoImg) {
            Notification::send($users, new NewNewsMailNotification($event->news, $logoImg));
        });
    }
}
