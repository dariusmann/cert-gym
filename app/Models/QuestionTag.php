<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class QuestionTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'label'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_question_tag', 'tag_id', 'question_id');
    }
}
