<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function akademiks()
    {
        return $this->hasMany(Akademik::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}
