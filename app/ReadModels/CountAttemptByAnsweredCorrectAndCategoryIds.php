<?php

declare(strict_types=1);

namespace App\ReadModels;

use Illuminate\Support\Facades\DB;

class CountAttemptByAnsweredCorrectAndCategoryIds
{
    public function count(bool $answeredCorrectly, array $categoryIds, int $userId): int
    {
        return DB::table('question_attempts')
            ->join('questions', 'question_attempts.question_id', 'questions.id')
            ->join('categories', 'categories.id', 'questions.id')
            ->where('question_attempts.user_id', $userId)
            ->whereIn('categories.id', $categoryIds)
            ->where('question_attempts.answered_correctly', '=', $answeredCorrectly)
            ->count();
    }
}
