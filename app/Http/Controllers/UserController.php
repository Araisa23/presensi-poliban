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
            'name'            => 'required',
            'jenis_kelamin'   => 'required',
            'role_id'         => 'required',

            'nip' => [
                'nullable',
                'unique:users,nip',
            ],

            'email' => [
                'nullable',
                'email',
                'unique:users,email',
            ],
        ]);

    return redirect()
        ->route('manajemen-user.administrator')
            ->with('success', 'User berhasil ditambahkan');
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

}