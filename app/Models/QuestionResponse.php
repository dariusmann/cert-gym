<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'answer_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }
}
