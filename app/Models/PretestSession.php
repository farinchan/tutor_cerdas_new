<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestSession extends Model
{
    use HasFactory;

    protected $table = 'pretest_session';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pretest()
    {
        return $this->belongsTo(Pretest::class, 'pretest_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function answers()
    {
        return $this->hasMany(PretestAnswer::class, 'pretest_session_id', 'id');
    }
}
