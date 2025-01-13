<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_id', 'id');
    }

    public function examSessions()
    {
        return $this->hasMany(ExamSession::class, 'exam_id', 'id');
    }

    public function examAnswers()
    {
        return $this->hasManyThrough(ExamAnswer::class, ExamQuestion::class, 'exam_id', 'exam_question_id', 'id', 'id');
    }
}
