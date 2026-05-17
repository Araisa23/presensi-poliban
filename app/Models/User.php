<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'nip',
        'jenis_kelamin',
        'pangkat',
        'unit_kerja_id',
        'email',
        'password',
        'role_id',
    ];
    
    public function role() { return $this->belongsTo(Role::class); }
    public function tenagaKependidikan() { return $this->hasOne(TenagaKependidikan::class); }
    public function rekapPresensi() { return $this->hasMany(RekapPresensi::class); }
    public function presensi() { return $this->hasMany(Presensi::class); }
    
    public function hasRole($roleName) {
        return $this->role && $this->role->name === $roleName;
    }
}