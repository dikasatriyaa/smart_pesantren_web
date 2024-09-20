<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kitabs()
    {
        return $this->hasMany(Kitab::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function aktivitasPendidikans()
    {
        return $this->hasMany(AktivitasPendidikan::class);
    }
}
