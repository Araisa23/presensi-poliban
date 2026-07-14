<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\PegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function administrator(Request $request)
    {
        $query = User::where('role_id', 1);

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10);

        return view(
            'admin.manajemen-user.administrator.index',
            compact('users')
        );
    }
    
    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.users.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,

            // dummy karena kolom masih ada di database
            'nip' => 'ADM-' . time(),
        ]);

        if ($user->role_id == 1) {
            return redirect()
                ->route('manajemen-user.administrator')
                ->with('success', 'Administrator berhasil ditambahkan');
        }

        if ($user->role_id == 3) {
            return redirect()
                ->route('admin.pimpinan.index')
                ->with('success', 'Pimpinan berhasil ditambahkan');
        }

        return redirect()
            ->route('admin.users.index');
    }
    /*
    |--------------------------------------------------------------------------
    | FORM IMPORT
    |--------------------------------------------------------------------------
    */
    public function importForm()
    {
        return view('admin.users.import');
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(
            new PegawaiImport,
            $request->file('file')
        );

        return redirect()
            ->route('manajemen-user.administrator')
            ->with('success', 'Data pegawai berhasil diimport');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'nip'  => 'required|unique:users,nip,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'nip'  => $request->nip,
        ]);

    return redirect()
        ->route('manajemen-user.administrator')
            ->with('success', 'User berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('manajemen-user.administrator')
            ->with('success', 'User berhasil dihapus');
    }

    public function resetDevice($id)
    {
        $user = \App\Models\User::findOrFail($id);

        $user->update([
            'device_id' => null,
            'device_registered_at' => null,
        ]);

        return back()->with('success', 'Device pengguna berhasil direset.');
    }
}