<?php

declare(strict_types=1);

namespace App\Application\QuestionRun;

use App\Domain\Builder\RunByQuestionsBuilder;
use App\Models\Question;
use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use App\Models\User;

class ReadRandomRunHandler
{
    private RunByQuestionsBuilder $runByQuestionsBuilder;

    public function __construct(RunByQuestionsBuilder $createRunByQuestions)
    {
        $this->runByQuestionsBuilder = $createRunByQuestions;
    }

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
        $questions = Question::take(3)->get();
        $shuffledQuestions = $questions->shuffle();

        return $this->runByQuestionsBuilder->create($shuffledQuestions, $user, 'random');
    }
}
