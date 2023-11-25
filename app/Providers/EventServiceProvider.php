<?php

namespace App\Providers;

use App\Events\FeedbackSendEvent;
use App\Events\PublishNewNewsEvent;
use App\Listeners\FeedbackSend;
use App\Listeners\FeedbackSendListener;
use App\Listeners\PublishNewNewsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FeedbackSendEvent::class => [
            FeedbackSendListener::class
        ],
        PublishNewNewsEvent::class => [
            PublishNewNewsListener::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
