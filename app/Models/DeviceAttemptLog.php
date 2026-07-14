<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAttemptLog extends Model
{
    protected $fillable = [
        'user_id',
        'attempted_device_id',
        'registered_device_id',
        'ip_address',
        'user_agent',
        'attempted_at',
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}