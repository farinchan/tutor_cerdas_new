<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    use HasFactory;

    protected $table = 'pretest';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function soal()
    {
        return $this->hasMany(PretestQuestion::class, 'pretest_id', 'id');
    }
}
