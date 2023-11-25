<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PrintLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'print:log {fileName?} {--clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->argument('fileName') ?? 'laravel';
        $filePath = storage_path("logs/$fileName.log");
        if (File::exists($filePath)) {
            if ($this->option('clear')) {
                File::put($filePath, '');
                $this->info("cleared: $fileName.log");
            } else {
                $logContent = file_get_contents($filePath);
                $this->info("Contents of $fileName.log:\n\n" . $logContent);
            }

        } else {
            $this->info("file '$fileName' not exist");
        }
    }
}
