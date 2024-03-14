<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionRunExam extends Model implements \JsonSerializable
{
    use HasFactory;

    protected $fillable = [
        'question_run_id',
        'started_at',
    ];

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'question_run_id' => $this->question_run_id,
            'started_at' => $this->started_at
        ];
    }
}
