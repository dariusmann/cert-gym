<?php

declare(strict_types=1);

namespace App\Domain\Resolver;

use App\Domain\Checker\CheckQuestionRunExamCompleted;
use App\Domain\Updater\QuestionRunExamCompletedUpdater;
use App\Models\QuestionRunExam;
use App\Models\User;
use App\ReadModels\FindNotCompletedExamByUser;

class UserRunningExamRunResolver
{
    private CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted;
    private FindNotCompletedExamByUser $findNotCompletedExamByUser;
    private QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater;

    public function __construct(
        CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted,
        FindNotCompletedExamByUser    $findNotCompletedExamByUser,
        QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater
    )
    {
        $this->checkQuestionRunExamCompleted = $checkQuestionRunExamCompleted;
        $this->findNotCompletedExamByUser = $findNotCompletedExamByUser;
        $this->questionRunExamCompletedUpdater = $questionRunExamCompletedUpdater;
    }

    public function resolve(User $user): ?QuestionRunExam
    {
        /** @var QuestionRunExam[] $notCompletedExams */
        $notCompletedExams = $this->findNotCompletedExamByUser->find($user);

        $runningExam = null;

        foreach ($notCompletedExams as $examRun) {
            if ($this->checkQuestionRunExamCompleted->check($examRun)) {
                $this->questionRunExamCompletedUpdater->update($examRun);
                continue;
            }

            $runningExam = $examRun;
        }

        return $runningExam;
    }
}
