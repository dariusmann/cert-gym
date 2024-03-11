<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuestionRunQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_run_id',
        'question_id',
        'order'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuestionId(): int
    {
        return $this->question_id;
    }

    public function setAttemptId(int $attemptId): void
    {
        $this->attempt_id = $attemptId;
    }

    public function getAttemptId(): ?int
    {
        return $this->attempt_id;
    }
}
