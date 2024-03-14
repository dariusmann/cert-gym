<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Run;

use App\Models\QuestionRunExam;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadQuestionRunExamController
{
    public function __invoke(Request $request, int $runId): JsonResponse
    {
        $questionRunExam = QuestionRunExam::where('question_run_id', $runId)->first();

        if ($questionRunExam === null) {
            $questionRunExam = QuestionRunExam::create([
                'question_run_id' => $runId,
                'started_at' => Carbon::now()
            ]);
        }

        return new JsonResponse($questionRunExam);
    }
}
