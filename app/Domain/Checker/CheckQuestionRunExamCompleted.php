<?php

declare(strict_types=1);

namespace App\Domain\Checker;

use App\Models\QuestionRunExam;
use Carbon\Carbon;

class CheckQuestionRunExamCompleted
{
    public function check(QuestionRunExam $questionRunExam): bool
    {
        if ($questionRunExam->isCompleted()) {
            return true;
        }

        $oneHourThirtyMinutesLater = $questionRunExam->getStartedAt()
            ->copy()
            ->addHour()
            ->addMinutes(30);

        $currentDateTime = Carbon::now('GMT');

        if ($currentDateTime->greaterThan($oneHourThirtyMinutesLater)) {
            return true;
        }

        return false;
    }
}
