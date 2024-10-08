<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';
    protected $primaryKey = 'kode_mk';
    protected $guarded = [];

    protected $keyType = 'string';
    public $incrementing = false;

    // public function kelas()
    // {
    //     return $this->hasMany(Kelas::class, 'kode_mk', 'kode_mk');
    // }
}
