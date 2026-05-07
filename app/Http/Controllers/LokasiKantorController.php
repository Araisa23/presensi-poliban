<?php

namespace App\Http\Controllers;

use App\Models\LokasiKantor;
use Illuminate\Http\Request;

class LokasiKantorController extends Controller
{
    public function index()
    {
        $lokasiKantor = LokasiKantor::paginate(10);
        return view('admin.lokasi-kantor.index', compact('lokasiKantor'));
    }

    public function create()
    {
        return view('admin.lokasi-kantor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'radius' => 'required|integer',
        ]);

        LokasiKantor::create($request->all());

        return redirect()->route('admin.lokasi-kantor.index')->with('success', 'Lokasi kantor berhasil ditambahkan.');
    }

    public function edit(LokasiKantor $lokasiKantor)
    {
        return view('admin.lokasi-kantor.edit', compact('lokasiKantor'));
    }

    public function update(Request $request, LokasiKantor $lokasiKantor)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'radius' => 'required|integer',
        ]);

        $lokasiKantor->update($request->all());

        return redirect()->route('admin.lokasi-kantor.index')->with('success', 'Lokasi kantor berhasil diperbarui.');
    }

    public function destroy(LokasiKantor $lokasiKantor)
    {
        $lokasiKantor->delete();
        return redirect()->route('admin.lokasi-kantor.index')->with('success', 'Lokasi kantor berhasil dihapus.');
    }
}
