<?php

namespace App\Http\Controllers;

use App\Imports\PegawaiImport;
use App\Exports\PegawaiTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Requests\PegawaiRequest;
use App\Models\TenagaKependidikan;
use App\Models\User;
use App\Models\UnitKerja;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = TenagaKependidikan::with(['user', 'unitKerja'])->paginate(10);
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('tenagaKependidikan')
            ->whereHas('role', function($q) {
                $q->where('name', 'pegawai');
            })
            ->get();

        $unitKerja = UnitKerja::all();

        return view('admin.pegawai.create', compact('users', 'unitKerja'));
    }

    public function store(PegawaiRequest $request)
    {
        $data = $request->validated();

        // 🔥 CEK BIAR TIDAK DOUBLE
        if (TenagaKependidikan::where('user_id', $data['user_id'])->exists()) {
            return back()
                ->with('error', 'User sudah punya data pegawai')
                ->withInput();
        }

        // 🔥 SIMPAN DATA
        TenagaKependidikan::create([
            'user_id' => $data['user_id'],
            'nama' => $data['nama'],
            'nip' => $data['nip'],
            'unit_kerja_id' => $data['unit_kerja_id'],
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = TenagaKependidikan::findOrFail($id);

        $users = User::whereHas('role', function($q) {
            $q->where('name', 'pegawai');
        })->get();

        $unitKerja = UnitKerja::all();

        return view('admin.pegawai.edit', compact('pegawai', 'users', 'unitKerja'));
    }

    public function update(PegawaiRequest $request, $id)
    {
        $pegawai = TenagaKependidikan::findOrFail($id);

        $data = $request->validated();

        // 🔥 CEK DOUBLE (kecuali dirinya sendiri)
        if (TenagaKependidikan::where('user_id', $data['user_id'])
            ->where('id', '!=', $id)
            ->exists()) {

            return back()
                ->with('error', 'User sudah dipakai oleh pegawai lain')
                ->withInput();
        }

        $pegawai->update($data);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = TenagaKependidikan::findOrFail($id);
        $pegawai->delete();

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new PegawaiImport, $request->file('file'));

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diimport.');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new PegawaiTemplateExport,
            'template_pegawai.xlsx'
        );
    }
}