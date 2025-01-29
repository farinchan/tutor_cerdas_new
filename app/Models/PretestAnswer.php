<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestAnswer extends Model
{
    use HasFactory;

    protected $table = 'pretest_answer';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pretest()
    {
        return $this->belongsTo(Pretest::class, 'pretest_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(PretestQuestion::class, 'pretest_question_id', 'id');
    }

    public function choice()
    {
        return $this->belongsTo(PretestChoice::class, 'pretest_choice_id', 'id');
    }

    public function session()
    {
        return $this->belongsTo(PretestSession::class, 'pretest_session_id', 'id');
    }
}
