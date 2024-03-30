<?php

declare(strict_types=1);

namespace App\Domain\Builder;

use App\Models\Question;
use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RunByQuestionsBuilder
{
    /**
     * @param Collection $questions
     */
    public function create(Collection $questions, User $user, string $type): QuestionRun
    {
        /** @var QuestionRun $questionRun */
        $questionRun = QuestionRun::create([
            'user_id' => $user->getId(),
            'type' => $type,
            'status' => 'not_started'
        ]);

        $questionRunQuestions = $questions->map(function ($question, $index) use ($questionRun) {
            return [
                'question_run_id' => $questionRun->getId(),
                'question_id' => $question->getId(),
                'order' => $index + 1
            ];
        })->toArray();

        QuestionRunQuestion::insert($questionRunQuestions);

        return $questionRun;
    }
}
