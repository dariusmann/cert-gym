<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionLearningObjective extends Model
{
    use HasFactory;

    protected $fillable = [
        'csin',
        'learning_objective',
        'explanation',
        'category_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }
}
