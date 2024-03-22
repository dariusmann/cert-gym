<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionRunCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_run_id',
        'categories'
    ];

    public function questionRun()
    {
        return $this->belongsTo(QuestionRun::class);
    }
}
