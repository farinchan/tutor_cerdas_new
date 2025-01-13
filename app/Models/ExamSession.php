<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    use HasFactory;

    protected $table = 'exam_session';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'exam_session_id', 'id');
    }

    public function examQuestions()
    {
        return $this->hasManyThrough(ExamQuestion::class, Exam::class, 'id', 'exam_id', 'exam_id', 'id');
    }

    public function examChoices()
    {
        return $this->hasManyThrough(ExamChoice::class, ExamQuestion::class, 'exam_id', 'exam_question_id', 'exam_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
