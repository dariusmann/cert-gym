<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionRunExam extends Model implements \JsonSerializable
{
    use HasFactory;

    protected $fillable = [
        'question_run_id',
        'started_at',
        'completed'
    ];

    public function getQuestionRunId(): int
    {
        return $this->question_run_id;
    }

    public function setCompleted(): void
    {
        $this->completed = true;
    }

    public function isCompleted(): bool
    {
        return $this->completed == 1;
    }

    public function getStartedAt(): Carbon
    {
        return Carbon::parse($this->started_at);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'question_run_id' => $this->question_run_id,
            'started_at' => $this->started_at,
            'completed' => $this->completed
        ];
    }
}
