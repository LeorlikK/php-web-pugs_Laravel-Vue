<?php

namespace App\Listeners;

use App\Events\FeedbackSendEvent;
use App\Models\User;
use App\Notifications\FeedbackMailNotification;
use App\Service\BaseCodeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FeedbackSendListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FeedbackSendEvent $event): void
    {
        $service = new BaseCodeService();
        $logoImg = $service->encodeLogoMail();

        $admins = User::where('role', 'admin')->get();
        $admins->each(function (User $user) use($event, $logoImg) {
            $user->notify(new FeedbackMailNotification($event->from, $event->feedback, $logoImg));
        });
    }
}
