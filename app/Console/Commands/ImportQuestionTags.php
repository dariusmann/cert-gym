<?php

namespace App\Console\Commands;

use App\Models\QuestionTag;
use Illuminate\Console\Command;

class ImportQuestionTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-question-tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tags = [
            [
                'identifier' => 'easy',
                'label' => 'easy'
            ],
            [
                'identifier' => 'medium',
                'label' => 'medium'
            ],
            [
                'identifier' => 'hard',
                'label' => 'hard'
            ]
        ];

        foreach ($tags as $tag) {
            QuestionTag::create($tag);
        }
    }
}
