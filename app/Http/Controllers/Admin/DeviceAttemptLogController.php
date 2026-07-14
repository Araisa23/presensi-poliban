<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceAttemptLog;

class DeviceAttemptLogController extends Controller
{
    public function index()
    {
        $logs = DeviceAttemptLog::with('user.tenagaKependidikan')
            ->latest('attempted_at')
            ->paginate(15);

        return view('admin.device-logs.index', compact('logs'));
    }
}