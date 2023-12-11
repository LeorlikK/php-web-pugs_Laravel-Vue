<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatisticsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = (60 * 30);
    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly array $fullStatistics, public readonly string $logoImg)
    {
        //
    }

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
            ->subject('Statistics Pugs')
            ->line('The introduction to the notification.')
            ->line('Thank you for using our application!')
            ->markdown('vendor.notifications.statistics', [
                'title' => 'Statistics - ' . now()->format('Y-m-d'),
                'logoImg' => $this->logoImg,
                'statistics' => $this->fullStatistics
            ]);
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
