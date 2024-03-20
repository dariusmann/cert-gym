<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use JsonSerializable;

class Question extends Model implements JsonSerializable
{
    use HasFactory;

    protected $fillable = [
        'text',
        'category_id',
        'learning_objective_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(QuestionTag::class, 'question_question_tag', 'question_id', 'tag_id');
    }

    private function getCategoryHierarchy($category, $hierarchy = []): array
    {
        if (!$category) {
            return array_reverse($hierarchy);
        }

        $hierarchy[] = [
            'id' => $category->id,
            'name' => $category->name,
        ];

        return $this->getCategoryHierarchy($category->parent, $hierarchy);
    }

    public function getCorrectAnswers(): array
    {
        $answers = $this->hasMany(QuestionAnswer::class);

        $correctAnswers = [];

        foreach ($answers as $answer) {
            if ($answer->isCorrect()) {
                $correctAnswers[] = $answer;
            }
        }

        return $correctAnswers;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'text' => $this->text,
            'category_id' => $this->category_id,
            'category_path' => $this->getCategoryHierarchy($this->category),
            'answers' => $this->answers()->get()->toArray(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
