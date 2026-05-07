<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiLog extends Model
{
    use HasFactory;

    protected $table = 'presensi_logs';
    protected $fillable = ['presensi_id', 'keterangan'];

    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }
}
