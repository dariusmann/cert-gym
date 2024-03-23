<?php

namespace App\Http\Controllers\Pages;

use App\Domain\Resolver\UserRunningExamRunResolver;
use App\Http\Controllers\Controller;
use App\Models\QuestionRun;
use App\Models\QuestionRunExam;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    private UserRunningExamRunResolver $userRunningExamRunResolver;

    public function __construct(
        UserRunningExamRunResolver $userRunningExamRunResolver
    )
    {
        $this->userRunningExamRunResolver = $userRunningExamRunResolver;
    }

    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $exam = $this->userRunningExamRunResolver->resolve($user);

        $run = null;

        if ($exam !== null) {
            $run = QuestionRun::find($exam->getQuestionRunId());
        }

        return Inertia::render('Dashboard', [
            'runningExamRun' => $run
        ]);
    }
}
