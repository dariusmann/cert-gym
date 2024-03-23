<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionAttempt;
use App\Models\QuestionResponse;
use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RunResultPage
{
    public function __invoke(Request $request, int $runId): Response
    {
        $questionRunQuestions = QuestionRunQuestion::where('question_run_id', $runId)->get();

        $correctAnswersCount = $questionRunQuestions->filter->isAnswerCorrect()->count();
        $incorrectAnswersCount = $questionRunQuestions->filter->isAnswerIncorrect()->count();

        // Calculate if the user passed the run for the server side
        $passThreshold = 0.6;
        $totalQuestions = $questionRunQuestions->count();
        $passed = $correctAnswersCount / $totalQuestions >= $passThreshold;

        return Inertia::render('Run/Result', [
            'run' => [
                'id' => $runId,
                'run_questions' => $questionRunQuestions->toArray(),
                'correct_answers_count' => $correctAnswersCount,
                'incorrect_answers_count' => $incorrectAnswersCount,
                'passed' => $passed,
            ]
        ]);
    }
}
