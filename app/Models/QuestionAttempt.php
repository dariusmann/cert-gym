<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuestionAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'answered_correctly',
        'created_at'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function answeredCorrectly(): bool
    {
        return $this->answered_correctly === 1;
    }

    public function responses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class, 'attempt_id');
    }

    public function attempt()
    {
        return $this->hasOne(QuestionAttempt::class, 'id', 'attempt_id');
    }

    public function toArray(): array
    {
        return [
            'responses' => $this->responses()->get(),
            'answered_correctly' => $this->answeredCorrectly()
        ];
    }
}
