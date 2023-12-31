<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = (60 * 10);
    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly string $from ,
        private readonly string $feedback,
        public readonly string $logoImg)
    {
        //
    }

//    public function viaQueues(): array
//    {
//        return [
//            'mail' => 'mail-queue-feedback',
//        ];
//    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->mailer('smtp')
            ->subject('Feedback from user.')
            ->from($this->from, $this->from)
            ->line($this->feedback)
            ->markdown('vendor.notifications.feedback', ['emailUser' => $this->from, 'logoImg' => $this->logoImg]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
