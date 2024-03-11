<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'short_code',
        'description',
        'parent_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    

}
