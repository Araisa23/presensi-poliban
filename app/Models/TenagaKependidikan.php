<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaKependidikan extends Model
{
    use HasFactory;

    protected $table = 'tenaga_kependidikans';
    protected $fillable = ['user_id', 'nip', 'nama', 'unit_kerja_id', 'face_registered'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
}
