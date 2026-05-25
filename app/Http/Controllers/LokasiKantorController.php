<?php

namespace App\Http\Controllers;

use App\Models\LokasiKantor;
use Illuminate\Http\Request;

class LokasiKantorController extends Controller
{
    public function index()
    {
        $lokasiKantor = LokasiKantor::first();

        if (!$lokasiKantor) {
            return redirect()->route('admin.lokasi-kantor.create')
                ->with('info', 'Silakan tambahkan lokasi kantor terlebih dahulu.');
        }

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
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|integer',
        ]);

        LokasiKantor::create([
            'nama_lokasi' => $request->nama_lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return redirect()
            ->route('admin.lokasi-kantor.index')
            ->with('success', 'Lokasi kantor berhasil ditambahkan.');
    }

    public function edit(LokasiKantor $lokasiKantor)
    {
        return view('admin.lokasi-kantor.edit', compact('lokasiKantor'));
    }

    public function update(Request $request, LokasiKantor $lokasiKantor)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|integer|min:1',
        ]);

        $lokasiKantor->update([
            'nama_lokasi' => $request->nama_lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return redirect()
            ->route('admin.lokasi-kantor.index')
            ->with('success', 'Radius berhasil diperbarui.');
    }

    public function destroy(LokasiKantor $lokasiKantor)
    {
        $lokasiKantor->delete();

        return redirect()
            ->route('admin.lokasi-kantor.index')
            ->with('success', 'Lokasi kantor berhasil dihapus.');
    }
}