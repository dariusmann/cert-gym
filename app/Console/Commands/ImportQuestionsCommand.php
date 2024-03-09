<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportQuestionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import questions from JSON files in storage/questions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get JSON
        $files = Storage::disk('local')->files('questions');

        // Decode JSON
        foreach ($files as $file) {
            $question = json_decode(Storage::disk('local')->get($file), true);

            if (!is_array($question)) {
                continue;
            }

            if (!isset($question['topic'])) {
                continue;
            }

            $category = Category::where('short_code', $question['topic'])->first();

            // Insert question
            if ($category) {
                $questionModel = Question::create([
                    'text' => $question['question_text'],
                    'category_id' => $category->id,
                ]);

                if (!is_array($question)) {
                    continue;
                }

                // Insert answers
                foreach ($question['options'] as $optionKey => $optionValue) {
                    $isCorrect = $optionKey === $question['correct_answer'];
                    $questionModel->answers()->create([
                        'text' => $optionValue,
                        'is_correct' => $isCorrect,
                        'explanation' => $question['explanation'][$optionKey],
                    ]);
                }
            }
        }
    }
}
