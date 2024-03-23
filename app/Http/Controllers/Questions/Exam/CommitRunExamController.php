<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Exam;

use App\Models\QuestionRun;
use App\Models\QuestionRunExam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommitRunExamController
{
    public function __invoke(Request $request): Response
    {
        $runId = $request->get('question_run_id');

        /** @var QuestionRunExam $runExam */
        $runExam = QuestionRunExam::where('question_run_id', $runId)->first();
        $runExam->setCompleted();;
        $runExam->save();

        /** @var QuestionRun $questionRun */
        $questionRun = QuestionRun::find($runId);

        $questionRun->setFinished();
        $questionRun->save();

        return new Response('OK');
    }
}
