<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKantor extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kantors';
    protected $fillable = ['nama_lokasi', 'latitude', 'longitude', 'radius'];
}
