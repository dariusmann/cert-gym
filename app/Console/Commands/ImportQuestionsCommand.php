<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionLearningObjective;
use App\Models\QuestionLesson;
use App\Models\QuestionTag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportQuestionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-questions';

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
            $category = $this->resolveCategory($question['topic']);
            $learningObject = $this->resolveLearningObjective($question['learning_objective_csin']);
            $tag = $this->resolveTag($question['difficulty']);

            /** @var Question $questionModel */
            $questionModel = Question::create([
                'text' => $question['question_text'],
                'category_id' => $category->getId(),
                'learning_objective_id' => $learningObject->getId()
            ]);

            QuestionLesson::create([
                'text' => $question['topic_explanation'],
                'question_id' => $questionModel->getId()
            ]);

            $questionModel->tags()->attach($tag->getId());

            $this->info($file);

            // Insert answers
            foreach ($question['options'] as $optionKey => $optionValue) {
                $isCorrect = $optionKey === $question['correct_answer'];
                $questionModel->answers()->create([
                    'text' => $optionValue,
                    'is_correct' => $isCorrect,
                    'explanation' => $question['short_explanation'][$optionKey],
                    'long_explanation' => $question['long_explanation'][$optionKey],
                ]);
            }
        }
    }

    /**
     * @param $topic
     * @return Category
     */
    private function resolveCategory($topic): Category
    {
        /** @var Category $category */
        $category = Category::where('short_code', $topic)->first();
        return $category;
    }

    /**
     * @param $csin
     * @return QuestionLearningObjective
     */
    private function resolveLearningObjective($csin): QuestionLearningObjective
    {
        /** @var QuestionLearningObjective $learningObject */
        $learningObject = QuestionLearningObjective::where('csin', $csin)->first();
        return $learningObject;
    }

    /**
     * @param $difficulty
     * @return void
     */
    private function resolveTag($difficulty): QuestionTag
    {
        return QuestionTag::where('identifier', $difficulty)->first();
    }
}
