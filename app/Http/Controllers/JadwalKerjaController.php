<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        $jadwalKerja = JadwalKerja::orderBy('id')->get();
        return view('admin.jadwal-kerja.index', compact('jadwalKerja'));
    }

    public function create()
    {
        return view('admin.jadwal-kerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|unique:jadwal_kerjas,hari',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        JadwalKerja::create($request->all());

        return redirect()->route('admin.jadwal-kerja.index')->with('success', 'Jadwal kerja berhasil ditambahkan.');
    }

    public function edit(JadwalKerja $jadwalKerja)
    {
        return view('admin.jadwal-kerja.edit', compact('jadwalKerja'));
    }

    public function update(Request $request, JadwalKerja $jadwalKerja)
    {
        $request->validate([
            'hari' => 'required|unique:jadwal_kerjas,hari,' . $jadwalKerja->id,
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        $data = $request->all();
        $data['is_libur'] = $request->has('is_libur');

        $jadwalKerja->update($data);

        return redirect()->route('admin.jadwal-kerja.index')->with('success', 'Jadwal kerja berhasil diperbarui.');
    }

    public function destroy(JadwalKerja $jadwalKerja)
    {
        $jadwalKerja->delete();
        return redirect()->route('admin.jadwal-kerja.index')->with('success', 'Jadwal kerja berhasil dihapus.');
    }
}
