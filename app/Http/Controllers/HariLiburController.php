<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hariLiburs = HariLibur::latest()->paginate(10);
        return view('admin.hari-libur.index', compact('hariLiburs'));
    }

    public function create()
    {
        return view('admin.hari-libur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'keterangan' => 'nullable|string|max:255',
        ]);

        HariLibur::create($request->all());

        return redirect()->route('admin.hari-libur.index')->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function edit(HariLibur $hariLibur)
    {
        return view('admin.hari-libur.edit', compact('hariLibur'));
    }

    public function update(Request $request, HariLibur $hariLibur)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal,' . $hariLibur->id,
            'keterangan' => 'nullable|string|max:255',
        ]);

        $hariLibur->update($request->all());

        return redirect()->route('admin.hari-libur.index')->with('success', 'Hari libur berhasil diperbarui.');
    }

    public function destroy(HariLibur $hariLibur)
    {
        $hariLibur->delete();
        return redirect()->route('admin.hari-libur.index')->with('success', 'Hari libur berhasil dihapus.');
    }
}
