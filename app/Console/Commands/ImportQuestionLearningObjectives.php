<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\QuestionLearningObjective;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportQuestionLearningObjectives extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-learning-objectives';

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
        // Get JSON
        $json = Storage::get('learning_objectives.json');

        // Decode JSON
        $data = json_decode($json, true);


        foreach ($data as $chunk) {
            foreach ($chunk['learning_objectives'] as  $learningObjective) {
                /** @var Category $category */
                $category = Category::where('short_code', $chunk['task_list_short_code'])->first();

                QuestionLearningObjective::create([
                    'csin' => $learningObjective['csin'],
                    'learning_objective'=> $learningObjective['learning_objective'],
                    'explanation'=> $learningObjective['explanation'],
                    'category_id'=> $category->getId()
                ]);
            }
        }
    }
}
