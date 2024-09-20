<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function hafalans()
    {
        return $this->hasMany(Hafalan::class);
    }

    public function akademiks()
    {
        return $this->hasMany(Akademik::class);
    }

    public function kesehatans()
    {
        return $this->hasMany(Kesehatan::class);
    }
}
