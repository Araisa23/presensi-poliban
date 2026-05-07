<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiFoto extends Model
{
    use HasFactory;

    protected $table = 'presensi_fotos';
    protected $fillable = ['presensi_id', 'foto'];

    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }
}
