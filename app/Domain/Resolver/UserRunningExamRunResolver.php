<?php

declare(strict_types=1);

namespace App\Domain\Resolver;

use App\Domain\Checker\CheckQuestionRunExamCompleted;
use App\Models\QuestionRunExam;
use App\Models\User;
use App\ReadModels\FindNotCompletedExamByUser;

class UserRunningExamRunResolver
{
    private CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted;
    private FindNotCompletedExamByUser $findNotCompletedExamByUser;

    public function __construct(
        CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted,
        FindNotCompletedExamByUser    $findNotCompletedExamByUser
    )
    {
        $this->checkQuestionRunExamCompleted = $checkQuestionRunExamCompleted;
        $this->findNotCompletedExamByUser = $findNotCompletedExamByUser;
    }

    public function resolve(User $user): ?QuestionRunExam
    {
        /** @var QuestionRunExam[] $notCompletedExams */
        $notCompletedExams = $this->findNotCompletedExamByUser->find($user);

        $runningExam = null;

        foreach ($notCompletedExams as $examRun) {
            if ($this->checkQuestionRunExamCompleted->check($examRun)) {
                $examRun->setCompleted();
                $examRun->save();
                continue;
            }

            $runningExam = $examRun;
        }

        return $runningExam;
    }
}
