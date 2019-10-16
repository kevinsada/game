<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'category_id', 'difficulty_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
