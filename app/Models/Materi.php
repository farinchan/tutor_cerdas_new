<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'file' => 'array',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function getThumbnail()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-thumbnail.jpg');
    }


}
