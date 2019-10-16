<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['answer', 'is_correct', 'question_id'];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
