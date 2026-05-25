<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with([
            'role',
            'tenagaKependidikan.unitKerja'
        ]);

        // FILTER ROLE
        if ($request->role) {

            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // SEARCH
        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('email', 'like', "%{$search}%")

                    ->orWhereHas('tenagaKependidikan', function ($pegawai) use ($search) {

                        $pegawai->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->latest()->paginate(10);

        $roles = Role::all();

        return view('admin.manajemen-user.index', compact(
            'users',
            'roles'
        ));
    }
}