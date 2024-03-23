<?php

declare(strict_types=1);

namespace App\ReadModels;

use Illuminate\Support\Facades\DB;

class CountAttemptByAnsweredCorrectAndCategoryIds
{
    public function count(bool $answeredCorrectly, array $categoryIds, int $userId): int
    {
        return DB::table('question_attempts')
            ->leftJoin('questions', 'questions.id', '=', 'question_attempts.question_id')
            ->where('question_attempts.user_id', $userId)
            ->whereIn('questions.category_id', $categoryIds)
            ->where('question_attempts.answered_correctly', '=', $answeredCorrectly)
            ->count();
    }
}
