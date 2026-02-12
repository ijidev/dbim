<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'course_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
        'shuffle_questions',
        'show_results_immediately',
        'max_attempts',
        'is_published',
    ];

    protected $casts = [
        'shuffle_questions' => 'boolean',
        'show_results_immediately' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function getTotalPointsAttribute()
    {
        return $this->questions()->sum('points');
    }
}
