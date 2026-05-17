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
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
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
            'nip'             => 'required|unique:users,nip',
            'name'            => 'required',
            'jenis_kelamin'   => 'required',
            'pangkat'         => 'nullable',
            'role_id'         => 'required',
        ]);

        User::create([
            'nip'             => $request->nip,
            'name'            => $request->name,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'pangkat'         => $request->pangkat,
            'unit_kerja'      => $request->unit_kerja,

            // password default = NIP
            'password'        => Hash::make($request->nip),

            'role_id'         => $request->role_id,
        ]);

        return redirect()
            ->route('admin.users.index')
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
            ->route('admin.users.index')
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
            ->route('admin.users.index')
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
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}