<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasPendidikan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}
