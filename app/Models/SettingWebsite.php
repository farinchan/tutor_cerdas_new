<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingWebsite extends Model
{
    use HasFactory;

    protected $table = 'setting_website';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getFavicon()
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : "https://cdn.hashnode.com/res/hashnode/image/upload/v1690181374651/bYA88VvdJ.png";
    }

    public function getLogo()
    {
        return $this->logo ? asset('storage/' . $this->logo) : "https://cdn.hashnode.com/res/hashnode/image/upload/v1690181374651/bYA88VvdJ.png";
    }
}
