<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PretestChoice extends Model
{
    use HasFactory;

    protected $table = 'pretest_choice';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function question()
    {
        return $this->belongsTo(PretestQuestion::class, 'pretest_question_id', 'id');
    }

    public function getImage()
    {
        return Storage::url($this->choice_image);
    }


}
