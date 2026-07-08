<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use App\Models\KalenderAkademik;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'keterangan'      => 'nullable|string',
        ]);

        $isLibur = $this->resolveIsLibur($request);

        $event = KalenderAkademik::create([
            'judul'           => $request->judul,
            'jenis'           => $request->jenis,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan'      => $request->keterangan,
            'is_libur'        => $isLibur,
        ]);

        if ($event->is_libur) {
            $this->syncHariLibur($event);
        }

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
            'judul'           => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis'           => 'required|in:akademik,nasional',
            'keterangan'      => 'nullable|string',
        ]);

        $wasLibur = (bool) $kalenderAkademik->is_libur;
        $oldJudul = $kalenderAkademik->judul;
        $oldMulai = $kalenderAkademik->tanggal_mulai;
        $oldSelesai = $kalenderAkademik->tanggal_selesai;

        if ($wasLibur) {
            $this->removeHariLiburByRange($oldJudul, $oldMulai, $oldSelesai);
        }

        $isLibur = $this->resolveIsLibur($request);

        $kalenderAkademik->update([
            'judul'           => $request->judul,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis'           => $request->jenis,
            'is_libur'        => $isLibur,
            'keterangan'      => $request->keterangan,
        ]);

        $kalenderAkademik->refresh();

        if ($kalenderAkademik->is_libur) {
            $this->syncHariLibur($kalenderAkademik);
        }

        return redirect()
            ->route('admin.kalender-akademik.index')
            ->with('success', 'Kalender berhasil diperbarui.');
    }

    public function destroy(KalenderAkademik $kalenderAkademik)
    {
        if ($kalenderAkademik->is_libur) {
            $this->removeHariLiburByRange(
                $kalenderAkademik->judul,
                $kalenderAkademik->tanggal_mulai,
                $kalenderAkademik->tanggal_selesai
            );
        }

        $kalenderAkademik->delete();

        return redirect()
            ->back()
            ->with('success', 'Event berhasil dihapus.');
    }

    private function resolveIsLibur(Request $request): bool
    {
        return in_array($request->input('is_libur'), ['1', 1, true, 'true', 'on'], true);
    }

    private function syncHariLibur(KalenderAkademik $event): void
    {
        $mulai = Carbon::parse($event->tanggal_mulai);
        $selesai = $event->tanggal_selesai
            ? Carbon::parse($event->tanggal_selesai)
            : Carbon::parse($event->tanggal_mulai);

        while ($mulai->lte($selesai)) {
            HariLibur::updateOrCreate(
                ['tanggal' => $mulai->toDateString()],
                [
                    'keterangan'  => $event->judul,
                    'is_nasional' => $event->jenis === 'nasional',
                ]
            );

            $mulai->addDay();
        }
    }

    private function removeHariLiburByRange(string $judul, $tanggalMulai, $tanggalSelesai = null): void
    {
        $mulai = Carbon::parse($tanggalMulai);
        $selesai = $tanggalSelesai
            ? Carbon::parse($tanggalSelesai)
            : Carbon::parse($tanggalMulai);

        while ($mulai->lte($selesai)) {
            HariLibur::where('tanggal', $mulai->toDateString())
                ->where('keterangan', $judul)
                ->delete();

            $mulai->addDay();
        }
    }
}
