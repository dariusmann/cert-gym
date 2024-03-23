<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use JsonSerializable;

class QuestionRunQuestion extends Model implements JsonSerializable
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

    public function attempt()
    {
        return $this->hasOne(QuestionAttempt::class, 'id', 'attempt_id');
    }

    public function question(): Question
    {
        return Question::find($this->getQuestionId());
    }

    public function flag(): ?QuestionRunExamFlag
    {
        return QuestionRunExamFlag::where('question_run_question_id', $this->getId())->first();
    }

    public function getAttemptId(): ?int
    {
        return $this->attempt_id;
    }

    public function getQuestionRunId(): int
    {
        return $this->question_run_id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'question' => $this->question()->toArray(),
            'attempt' => $this->attempt?->toArray(),
            'flag' => $this->flag()?->toArray()
        ];
    }

    public function isAnswerCorrect()
    {
        return $this->attempt && $this->attempt->answer && $this->attempt->answer->is_correct;
    }

    public function isAnswerIncorrect()
    {
        return $this->attempt && $this->attempt->answer && !$this->attempt->answer->is_correct;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
