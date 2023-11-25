<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:table {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tableName = $this->argument('tableName');
        if (Schema::hasTable($tableName)) {
            try {
                DB::table($tableName)->truncate();
                $this->info("Table '$tableName' is cleared.");
            }catch (\Throwable $exception) {
                $this->info($exception->getMessage());
            }
        } else {
            $this->info("Table '$tableName' not exist.");
        }
    }
}
