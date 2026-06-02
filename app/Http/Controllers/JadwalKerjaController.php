<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

    class JadwalKerjaController extends Controller
    {
        public function index(Request $request)
        {
            $jadwalKerja = JadwalKerja::query()

                ->when($request->search, function ($query) use ($request) {

                    $query->where('hari', 'like', '%' . $request->search . '%')
                        ->orWhere('nama_jadwal', 'like', '%' . $request->search . '%');
                })

                ->when($request->status, function ($query) use ($request) {

                    if ($request->status == 'aktif') {
                        $query->where('is_libur', 0);
                    }

                    if ($request->status == 'libur') {
                        $query->where('is_libur', 1);
                    }
                })

                ->latest()
                ->get();

            return view('admin.jadwal-kerja.index', compact('jadwalKerja'));
        }

        public function create()
        {
            return view('admin.jadwal-kerja.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'nama_jadwal'         => 'required|string|max:255',

                'hari'                => 'required|array',

                'jam_masuk'           => 'required',
                'jam_pulang'          => 'required',

                'batas_awal_masuk'    => 'nullable',
                'batas_akhir_masuk'   => 'nullable',

                'batas_awal_pulang'   => 'nullable',
                'batas_akhir_pulang'  => 'nullable',
            ]);

            JadwalKerja::create([

                'nama_jadwal' => $request->nama_jadwal,

                // convert array hari -> string
                'hari' => implode(', ', $request->hari),

                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,

                'batas_awal_masuk' => $request->batas_awal_masuk,
                'batas_akhir_masuk' => $request->batas_akhir_masuk,

                'batas_awal_pulang' => $request->batas_awal_pulang,
                'batas_akhir_pulang' => $request->batas_akhir_pulang,

                // fitur
                'is_libur' => $request->has('is_libur'),

                'is_wfh' => $request->has('is_wfh'),

                'use_camera' => $request->has('use_camera'),

                'use_location' => $request->has('use_location'),
            ]);

            return redirect()
                ->route('admin.jadwal-kerja.index')
                ->with('success', 'Jadwal kerja berhasil ditambahkan.');
        }

        public function edit(JadwalKerja $jadwalKerja)
        {
            return view('admin.jadwal-kerja.edit', compact('jadwalKerja'));
        }

        public function update(Request $request, JadwalKerja $jadwalKerja)
        {
            $request->validate([
                'nama_jadwal'         => 'required|string|max:255',

                'hari'                => 'required|array',

                'jam_masuk'           => 'required',
                'jam_pulang'          => 'required',

                'batas_awal_masuk'    => 'nullable',
                'batas_akhir_masuk'   => 'nullable',

                'batas_awal_pulang'   => 'nullable',
                'batas_akhir_pulang'  => 'nullable',
            ]);

            $jadwalKerja->update([

                'nama_jadwal' => $request->nama_jadwal,

                'hari' => implode(', ', $request->hari),

                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,

                'batas_awal_masuk' => $request->batas_awal_masuk,
                'batas_akhir_masuk' => $request->batas_akhir_masuk,

                'batas_awal_pulang' => $request->batas_awal_pulang,
                'batas_akhir_pulang' => $request->batas_akhir_pulang,

                // fitur
                'is_libur' => $request->has('is_libur'),

                'is_wfh' => $request->has('is_wfh'),

                'use_camera' => $request->has('use_camera'),

                'use_location' => $request->has('use_location'),
            ]);

            return redirect()
                ->route('admin.jadwal-kerja.index')
                ->with('success', 'Jadwal kerja berhasil diperbarui.');
        }

        public function destroy(JadwalKerja $jadwalKerja)
        {
            $jadwalKerja->delete();

            return redirect()
                ->route('admin.jadwal-kerja.index')
                ->with('success', 'Jadwal kerja berhasil dihapus.');
        }
    }