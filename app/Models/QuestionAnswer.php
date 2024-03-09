<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class QuestionAnswer extends Model implements JsonSerializable
{
    use HasFactory;

    protected $fillable = [
        'text',
        'is_correct',
        'explanation',
        'question_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function isCorrect(): bool
    {
        return $this->is_correct === 1;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'text' => $this->text,
            'is_correct' => $this->is_correct,
            'explanation' => $this->explanation
        ];
    }
}
