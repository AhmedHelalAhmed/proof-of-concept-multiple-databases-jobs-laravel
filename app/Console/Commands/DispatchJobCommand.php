<?php

namespace App\Console\Commands;

use App\Jobs\AddPostsJob;
use Illuminate\Console\Command;

class DispatchJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:job {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to dispatch jobs on different database connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        config(['database.default' => "service{$this->argument('id')}"]);
        dispatch(
            new AddPostsJob("on service{$this->argument('id')}",
                "service {$this->argument('id')} description")
        );
    }
}
