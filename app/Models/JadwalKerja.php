<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kerjas';

    protected $fillable = [
        'nama_jadwal',
        'hari',
        'jam_masuk',
        'jam_pulang',
        'batas_awal_masuk',
        'batas_akhir_masuk',
        'batas_awal_pulang',
        'batas_akhir_pulang',

        'is_wfh',
        'use_camera',
        'use_location',
    ];

    protected $casts = [
        'is_wfh' => 'boolean',
        'use_camera' => 'boolean',
        'use_location' => 'boolean',
    ];
}