<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportAllDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('app:import-question-tags');
        $this->call('app:import-categories');
        $this->call('app:import-learning-objectives');
        $this->call('app:import-questions');
    }
}
