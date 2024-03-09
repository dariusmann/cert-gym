<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionAttempt;
use App\Models\QuestionResponse;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class GenerateAttemptsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dev:generate:attempts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import questions from JSON files in storage/questions';

    public function handle()
    {
        /** @var User $user */
        $user = User::find(29);

        $questions = Question::all();
        $questionCount = $questions->count();
        $date = Carbon::now();

        $count = 1;

        foreach ($questions as $question) {
            $attempt = $this->createAttempt($question, $user, $date);

            $probabilityOfCorrect = $count / $questions->count();

            if ($this->createCorrectAttempt($questionCount, $probabilityOfCorrect)) {
                $answers = $question->getCorrectAnswers();
            } else {
                $answers = $this->resolveUnCorrectAnswer($question);
            }

            $this->createQuestionResponses($answers, $attempt);

            if (($count) % 5 === 0) {
                $date->addDay();
            }

            $count++;
        }
    }

    /**
     * @throws Exception
     */
    private function resolveUnCorrectAnswer(Question $question): array
    {
        /** @var QuestionAnswer $answer */
        foreach ($question->answers()->get() as $answer) {
            if (!$answer->isCorrect()) {
                return [$answer];
            }
        }

        throw new Exception('No un correct question found');
    }

    private function createCorrectAttempt(int $total, float $probability): bool
    {
        $a = (rand(0, $total) / $total);
        return $a < $probability;
    }

    /**
     * @param array $correctAnswers
     * @param QuestionAttempt $attempt
     * @return void
     */
    private function createQuestionResponses(array $correctAnswers, QuestionAttempt $attempt): void
    {
        /** @var QuestionAnswer $answer */
        foreach ($correctAnswers as $answer) {
            QuestionResponse::create([
                'attempt_id' => $attempt->getId(),
                'answer_id' => $answer->getId()
            ]);
        }
    }

    /**
     * @param mixed $question
     * @param User $user
     * @return QuestionAttempt
     */
    private function createAttempt(mixed $question, User $user, Carbon $date): QuestionAttempt
    {
        /** @var QuestionAttempt $attempt */
        $attempt = QuestionAttempt::create([
            'question_id' => $question->getId(),
            'user_id' => $user->getId(),
            'created_at' => $date
        ]);
        return $attempt;
    }
}
