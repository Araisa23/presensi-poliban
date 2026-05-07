<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensis';
    protected $fillable = ['user_id', 'tenaga_kependidikan_id', 'tanggal', 'jam_masuk', 'jam_pulang', 'lat', 'lng'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenagaKependidikan()
    {
        return $this->belongsTo(TenagaKependidikan::class);
    }

    public function foto()
    {
        return $this->hasMany(PresensiFoto::class);
    }

    public function log()
    {
        return $this->hasMany(PresensiLog::class);
    }
}
