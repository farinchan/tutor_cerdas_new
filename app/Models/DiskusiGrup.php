<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiGrup extends Model
{
    use HasFactory;

    protected $table = 'diskusi_grup';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'id');
    }
}
