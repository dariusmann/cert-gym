<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'status'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuestionRunQuestions(): HasMany
    {
        return $this->hasMany(QuestionRunQuestion::class);
    }

    public function setFinished()
    {
        $this->status = 'completed';
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'stats' => [
                'count' => $this->getQuestionRunQuestions()->count(),
                'answered' => $this->getQuestionRunQuestions()->whereNotNull('attempt_id')->count(),
            ]
        ];
    }

    public function questionRunCategories(): HasMany
    {
        return $this->hasMany(QuestionRunCategory::class);
    }
}
