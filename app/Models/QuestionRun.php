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

    public function getQuestionRunQuestions(): HasMany
    {
        return $this->hasMany(QuestionRunQuestion::class);
    }
}
