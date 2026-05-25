<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use App\Models\KalenderAkademik;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KalenderAkademikController extends Controller
{
    public function index()
    {
        $events = KalenderAkademik::latest()->get();

        return view(
            'admin.kalender-akademik.index',
            compact('events')
        );
    }

    public function create()
    {
        return view('admin.kalender-akademik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'jenis'           => 'required|in:akademik,nasional',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'nullable|string'
        ]);

        KalenderAkademik::create([

            'judul'            => $request->judul,

            'jenis'            => $request->jenis,

            'tanggal_mulai'    => $request->tanggal_mulai,

            'tanggal_selesai'  => $request->tanggal_selesai,

            'keterangan'       => $request->keterangan,

        ]);

        return redirect()->route('admin.kalender-akademik.index')
            ->with('success', 'Libur / Agenda berhasil ditambahkan!');
    }

    public function edit(KalenderAkademik $kalenderAkademik)
    {
        return view(
            'admin.kalender-akademik.edit',
            compact('kalenderAkademik')
        );
    }

    public function update(Request $request, KalenderAkademik $kalenderAkademik)
    {
        $request->validate([

            'judul' => 'required|string|max:255',

            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',

            'jenis' => 'required|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS LIBUR LAMA
        |--------------------------------------------------------------------------
        */

        HariLibur::where('keterangan', $kalenderAkademik->judul)
            ->delete();

        $kalenderAkademik->update([

            'judul' => $request->judul,

            'tanggal_mulai' => $request->tanggal_mulai,

            'tanggal_selesai' => $request->tanggal_selesai,

            'jenis' => $request->jenis,

            'is_libur' => $request->has('is_libur'),

            'keterangan' => $request->keterangan,
        ]);

        /*
        |--------------------------------------------------------------------------
        | INSERT ULANG JIKA LIBUR
        |--------------------------------------------------------------------------
        */

        if ($kalenderAkademik->is_libur) {

            $mulai = Carbon::parse($kalenderAkademik->tanggal_mulai);

            $selesai = $kalenderAkademik->tanggal_selesai
                ? Carbon::parse($kalenderAkademik->tanggal_selesai)
                : Carbon::parse($kalenderAkademik->tanggal_mulai);

            while ($mulai->lte($selesai)) {

                HariLibur::updateOrCreate(
                    [
                        'tanggal' => $mulai->toDateString()
                    ],
                    [
                        'keterangan' => $kalenderAkademik->judul
                    ]
                );

                $mulai->addDay();
            }
        }

    return redirect()
        ->route('admin.kalender-akademik.index')
        ->with('success', 'Kalender berhasil diperbarui.');
    }

    public function destroy(KalenderAkademik $kalenderAkademik)
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA HARI LIBUR TERKAIT
        |--------------------------------------------------------------------------
        */

        HariLibur::where('keterangan', $kalenderAkademik->judul)
            ->delete();

        $kalenderAkademik->delete();

        return redirect()
            ->back()
            ->with('success', 'Event berhasil dihapus.');
    }
}