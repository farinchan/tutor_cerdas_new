<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $table = 'exam_question';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function examChoices()
    {
        return $this->hasMany(ExamChoice::class, 'exam_question_id', 'id');
    }

    public function examAnswers()
    {
        return $this->hasOne(ExamAnswer::class, 'exam_question_id', 'id');
    }
}
