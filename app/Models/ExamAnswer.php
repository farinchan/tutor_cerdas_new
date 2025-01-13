<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $table = 'exam_answer';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function examQuestion()
    {
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id', 'id');
    }
    
}
