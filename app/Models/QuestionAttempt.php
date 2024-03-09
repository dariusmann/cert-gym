<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function answeredCorrectly(): bool
    {
        return $this->answered_correctly === 1;
    }
}
