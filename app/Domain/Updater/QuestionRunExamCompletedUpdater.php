<?php

declare(strict_types=1);

namespace App\Domain\Updater;

use App\Models\QuestionRun;
use App\Models\QuestionRunExam;

class QuestionRunExamCompletedUpdater
{
    public function update(QuestionRunExam $questionRunExam): void
    {
        $questionRunExam->setCompleted();
        $questionRunExam->save();

        /** @var QuestionRun $run */
        $run = QuestionRun::find($questionRunExam->getQuestionRunId());

        $run->setFinished();
        $run->save();
    }
}
