<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'created_at'
    ];

    public function getId(): int
    {
        return $this->id;
    }
}
