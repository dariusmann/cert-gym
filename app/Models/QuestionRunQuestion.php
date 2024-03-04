<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionRunQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_run_id',
        'question_id',
        'order'
    ];

    public function getId(): int
    {
        return $this->id;
    }
}
