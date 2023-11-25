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
    protected $signature = 'clear:table';

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
        $databaseName = DB::getDatabaseName();
        $tables = Schema::getAllTables();
        $tablesNames = [];
        foreach ($tables as $table) {
            $var = 'Tables_in_' . $databaseName;
            $tablesNames[] = $table->$var;
        }

        $answerNameTable = $this->choice('Choice table', $tablesNames);

        if (Schema::hasTable($answerNameTable)) {
            try {
                DB::table($answerNameTable)->truncate();
                $this->info("Table '$answerNameTable' is cleared.");
            }catch (\Throwable $exception) {
                $this->info($exception->getMessage());
            }
        } else {
            $this->info("Table '$answerNameTable' not exist.");
        }
    }
}
