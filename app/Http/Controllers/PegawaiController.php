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
    public function index(Request $request)
    {
        $pegawai = TenagaKependidikan::with(['user', 'unitKerja'])

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('nama', 'like', '%' . $request->search . '%')
                        ->orWhere('nip', 'like', '%' . $request->search . '%');
                });
            })

            ->when($request->unit_kerja, function ($query) use ($request) {

                $query->where('unit_kerja_id', $request->unit_kerja);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        $unitKerja = UnitKerja::all();

        return view('admin.pegawai.index', compact(
            'pegawai',
            'unitKerja'
        ));
    }

    public function create()
    {
        $users = User::whereDoesntHave('tenagaKependidikan')
            ->whereHas('role', function ($q) {

                $q->where('name', 'pegawai');
            })
            ->get();

        $unitKerja = UnitKerja::all();

        return view('admin.pegawai.create', compact(
            'users',
            'unitKerja'
        ));
    }

    public function store(PegawaiRequest $request)
    {
        $data = $request->validated();

        // CEK BIAR TIDAK DOUBLE
        if (
            TenagaKependidikan::where(
                'user_id',
                $data['user_id']
            )->exists()
        ) {

            return back()
                ->with('error', 'User sudah punya data pegawai')
                ->withInput();
        }

        // SIMPAN DATA
        TenagaKependidikan::create([
            'user_id'       => $data['user_id'],
            'nama'          => $data['nama'],
            'nip'           => $data['nip'],
            'unit_kerja_id' => $data['unit_kerja_id'],
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = TenagaKependidikan::findOrFail($id);

        $users = User::whereHas('role', function ($q) {

            $q->where('name', 'pegawai');
        })->get();

        $unitKerja = UnitKerja::all();

        return view('admin.pegawai.edit', compact(
            'pegawai',
            'users',
            'unitKerja'
        ));
    }

    public function update(PegawaiRequest $request, $id)
    {
        $pegawai = TenagaKependidikan::findOrFail($id);

        $data = $request->validated();

        // CEK DOUBLE (kecuali dirinya sendiri)
        if (
            TenagaKependidikan::where('user_id', $data['user_id'])
                ->where('id', '!=', $id)
                ->exists()
        ) {

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

        Excel::import(
            new PegawaiImport,
            $request->file('file')
        );

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diimport.');
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new PegawaiTemplateExport,
            'template_pegawai.xlsx'
        );
    }
}