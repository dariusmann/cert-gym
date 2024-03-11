<?php

declare(strict_types=1);

namespace App\Domain\Resolver;

use App\Models\Question;
use App\Models\QuestionAnswer;

class AnsweredCorrectlyResolver
{
    public function resolve(int $questionId, array $answersIds): bool
    {
        /** @var Question $question */
        $question = Question::find($questionId);
        $questionAnswers = $question->answers()->get();

        $correctAnswersIds = [];

        /** @var QuestionAnswer $answer */
        foreach ($questionAnswers as $answer) {
            if ($answer->isCorrect()) {
                $correctAnswersIds[] = $answer->getId();
            }
        }

        if (count($correctAnswersIds) !== count($answersIds)) {
            return false;
        }

        foreach ($answersIds as $answersId) {
            if (!in_array($answersId, $correctAnswersIds)) {
                return false;
            }
        }

        return true;
    }
}
