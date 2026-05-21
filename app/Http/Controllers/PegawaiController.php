<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
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
        $unitKerja = UnitKerja::all();

        return view('admin.pegawai.create', compact('unitKerja'));
    }

    public function store(PegawaiRequest $request)
    {
        $data = $request->validated();

        // BUAT USER OTOMATIS
        $user = User::create([
            'name' => $data['nama'],
            'nip' => $data['nip'],
            'password' => Hash::make('password123'),
            'role_id' => 2, // pegawai
        ]);

        // BUAT DATA PEGAWAI
        TenagaKependidikan::create([
            'user_id'         => $user->id,
            'nip'             => $data['nip'],
            'nama'            => $data['nama'],
            'jenis_kelamin'   => $data['jenis_kelamin'],
            'pangkat'         => $data['pangkat'],
            'unit_kerja_id'   => $data['unit_kerja_id'],
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

            $pegawai->update([
                'nip'             => $data['nip'],
                'nama'            => $data['nama'],
                'jenis_kelamin'   => $data['jenis_kelamin'],
                'pangkat'         => $data['pangkat'],
                'unit_kerja_id'   => $data['unit_kerja_id'],
            ]);

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