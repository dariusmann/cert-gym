<?php

declare(strict_types=1);

namespace App\Application\QuestionRun;

use App\Models\Question;
use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use App\Models\User;

class ReadRandomRunHandler
{
    public function read(User $user): QuestionRun
    {
        $questionRun = $this->findOneCurrentRandomQuestionRunByUser($user);

        if ($questionRun !== null) {
            return $questionRun;
        }

        return $this->createQuestionRun($user);
    }

    private function findOneCurrentRandomQuestionRunByUser(User $user): ?QuestionRun
    {
        return QuestionRun::where('user_id', $user->getId())
            ->where('type', 'random')
            ->whereNot('status', 'completed')
            ->first();
    }

    private function createQuestionRun(User $user): QuestionRun
    {
        $questions = Question::all();
        $shuffledQuestions = $questions->shuffle();


        /** @var QuestionRun $questionRun */
        $questionRun = QuestionRun::create([
            'user_id' => $user->getId(),
            'type' => 'random',
            'status' => 'created'
        ]);

        $order = 1;

        foreach ($shuffledQuestions as $question) {
            QuestionRunQuestion::create([
                'question_run_id' => $questionRun->getId(),
                'question_id' => $question->getId(),
                'order' => $order
            ]);

            $order++;
        }

        return $questionRun;
    }
}
