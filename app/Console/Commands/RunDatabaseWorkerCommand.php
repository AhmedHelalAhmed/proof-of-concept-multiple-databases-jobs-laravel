<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunDatabaseWorkerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:worker {databaseConnection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to run multiple databases workers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        config(['database.default' => $this->argument('databaseConnection')]);
        return Artisan::call('queue:work --stop-when-empty');
    }

}
