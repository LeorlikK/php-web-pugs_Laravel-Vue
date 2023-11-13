<?php

namespace App\Listeners;

use App\Events\FeedbackSendEvent;
use App\Models\User;
use App\Notifications\FeedbackMailNotification;
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
        $admins = User::where('role', 'admin')->get();
        $admins->each(function (User $user) use($event) {
            $user->notify(new FeedbackMailNotification($event->from, $event->feedback));
        });
    }
}
