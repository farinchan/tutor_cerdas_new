<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestQuestion extends Model
{
    use HasFactory;

    protected $table = 'pretest_question';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pretest()
    {
        return $this->belongsTo(Pretest::class, 'pretest_id', 'id');
    }

    public function choices()
    {
        return $this->hasMany(PretestChoice::class, 'pretest_question_id', 'id');
    }


}
