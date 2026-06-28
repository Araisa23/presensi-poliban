<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerja = UnitKerja::latest()->paginate(10);
        return view('admin.unit-kerja.index', compact('unitKerja'));
    }

    public function create()
    {
        return view('admin.unit-kerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit_kerjas,nama_unit',
        ], [
            'nama_unit.unique' => 'Nama unit kerja sudah ada.',
        ]);

        UnitKerja::create($request->all());

        return redirect()->route('admin.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('admin.unit-kerja.edit', compact('unitKerja'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit_kerjas,nama_unit,' . $unitKerja->id,
        ], [
            'nama_unit.unique' => 'Nama unit kerja sudah ada.',
        ]);

        $unitKerja->update($request->all());

        return redirect()->route('admin.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);

        if ($unitKerja->tenagaKependidikans()->exists()) {
            return back()->with(
                'error',
                'Unit kerja tidak dapat dihapus karena masih digunakan oleh data pegawai.'
            );
        }

        $unitKerja->delete();

        return back()->with(
            'success',
            'Unit kerja berhasil dihapus.'
        );
    }
}