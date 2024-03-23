<?php

declare(strict_types=1);

namespace App\ReadModels;

use App\Models\QuestionRunExam;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FindNotCompletedExamByUser
{
    public function find(User $user): Collection
    {
        return QuestionRunExam::leftJoin('question_runs', 'question_runs.id', '=', 'question_run_exams.id')
            ->where('question_runs.user_id', '=', $user->getId())
            ->where('question_run_exams.completed', false)
            ->get();
    }
}
