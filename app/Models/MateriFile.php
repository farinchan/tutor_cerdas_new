<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriFile extends Model
{
    use HasFactory;

    protected $table = 'materi_file';

    protected $fillable = [
        'materi_id',
        'file'
    ];
}
