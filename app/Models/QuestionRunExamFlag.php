<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class QuestionRunExamFlag extends Model implements JsonSerializable
{
    use HasFactory;

    protected $fillable = [
        'question_run_question_id',
    ];

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question_run_question_id' => $this->question_run_question_id
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
