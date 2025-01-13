<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamChoice extends Model
{
    use HasFactory;

    protected $table = 'exam_choice';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function examQuestion()
    {
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id', 'id');
    }
}
