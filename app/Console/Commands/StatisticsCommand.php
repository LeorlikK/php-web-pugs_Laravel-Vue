<?php

namespace App\Console\Commands;

use App\Jobs\StatisticsJob;
use App\Service\StatisticsService;
use Illuminate\Console\Command;

class StatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(StatisticsService $service)
    {
        StatisticsJob::dispatch();
    }
}
