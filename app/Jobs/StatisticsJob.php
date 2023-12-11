<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\FeedbackMailNotification;
use App\Notifications\NewNewsMailNotification;
use App\Notifications\StatisticsNotification;
use App\Service\BaseCodeService;
use App\Service\StatisticsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class StatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function failed(Throwable $exception): void
    {
        Log::channel('myLog')->error($exception->getMessage());
    }
    /**
     * Execute the job.
     */
    public function handle(StatisticsService $statisticsService, BaseCodeService $baseCodeService): void
    {
        $logoImg = $baseCodeService->encodeLogoMail();
        $fullStatistics = $statisticsService->fullStatistics();
        Log::channel('myLog')->info($fullStatistics);

        User::where('role', 'admin')->chunk(500, function ($users) use($fullStatistics, $logoImg) {
            Notification::send($users, new StatisticsNotification($fullStatistics, $logoImg));
        });
    }
}
