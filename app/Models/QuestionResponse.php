<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class QuestionResponse extends Model implements JsonSerializable
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

    public function getAnswerId(): int
    {
        return $this->answer_id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'answer' => QuestionAnswer::find($this->getAnswerId())->toArray()
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
