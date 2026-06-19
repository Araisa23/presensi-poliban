<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                    Rekapitulasi Presensi
                </h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Ringkasan kehadiran pegawai per bulan (hari kerja Senin–Jumat).
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pimpinan.rekap.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'user_id' => $userId]) }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                          bg-emerald-600 text-white text-xs font-black uppercase tracking-[0.18em]
                          shadow-sm hover:bg-emerald-700 hover:scale-[1.02] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a>

                <a href="{{ route('pimpinan.rekap.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'user_id' => $userId]) }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                          bg-rose-600 text-white text-xs font-black uppercase tracking-[0.18em]
                          shadow-sm hover:bg-rose-700 hover:scale-[1.02] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-12 0h12v4H6v-4z"/>
                    </svg>
                    Export PDF
                </a>
            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- FILTER --}}
        <form action="{{ route('pimpinan.rekap') }}" method="GET">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">

                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-4">
                    Filter Data
                </p>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    {{-- BULAN --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 block mb-2">
                            Bulan
                        </label>
                        <select name="bulan"
                                class="w-full rounded-2xl border border-slate-200
                                       bg-white px-4 py-3 text-sm font-medium
                                       text-slate-700 shadow-sm
                                       focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70]
                                       focus:outline-none">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 block mb-2">
                            Tahun
                        </label>
                        <select name="tahun"
                                class="w-full rounded-2xl border border-slate-200
                                       bg-white px-4 py-3 text-sm font-medium
                                       text-slate-700 shadow-sm
                                       focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70]
                                       focus:outline-none">
                            @for($i = 2024; $i <= now()->year + 1; $i++)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- PEGAWAI --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 block mb-2">
                            Pegawai
                        </label>
                        <select name="user_id"
                                class="w-full rounded-2xl border border-slate-200
                                       bg-white px-4 py-3 text-sm font-medium
                                       text-slate-700 shadow-sm
                                       focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70]
                                       focus:outline-none">
                            <option value="">Semua Pegawai</option>
                            @foreach($pegawaiList as $pegawai)
                                <option value="{{ $pegawai->user_id }}"
                                    {{ $userId == $pegawai->user_id ? 'selected' : '' }}>
                                    {{ $pegawai->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SUBMIT --}}
                    <div>
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2
                                       px-5 py-3 rounded-2xl font-black text-xs
                                       uppercase tracking-[0.18em]
                                       bg-gradient-to-r from-[#004b8d] to-[#006fcf]
                                       text-white shadow-sm
                                       hover:opacity-90 hover:scale-[1.01] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                            </svg>
                            Filter
                        </button>
                    </div>

                </div>

            </div>
        </form>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- TABLE HEADER INFO --}}
            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">
                            Data Rekap —
                            <span class="text-[#006fcf]">
                                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                            </span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Dihitung dari hari kerja Senin–Jumat
                            @if($totalHariKerja > 0)
                                · {{ $totalHariKerja }} hari kerja
                            @endif
                        </p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200">
                        {{ $totalPegawai }} pegawai
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/70">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">
                                Pegawai
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">
                                Unit Kerja
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 text-center">
                                Hari Kerja
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 text-center">
                                Hadir
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 text-center">
                                Alpha
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 text-center">
                                % Kehadiran
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse($rekap as $r)
                            @php
                                $persen = $r['total_hari'] > 0
                                    ? round(($r['hadir'] / $r['total_hari']) * 100)
                                    : 0;

                                $barColor = match(true) {
                                    $persen >= 90 => 'bg-emerald-500',
                                    $persen >= 75 => 'bg-yellow-400',
                                    default       => 'bg-rose-500',
                                };

                                $textColor = match(true) {
                                    $persen >= 90 => 'text-emerald-700',
                                    $persen >= 75 => 'text-yellow-700',
                                    default       => 'text-rose-700',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50 transition">

                                {{-- NAMA --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl
                                                    bg-gradient-to-br from-[#004b8d] to-[#006fcf]
                                                    text-white flex items-center justify-center
                                                    font-black text-sm shadow-sm flex-shrink-0">
                                            {{ strtoupper(substr($r['nama'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-sm leading-tight">
                                                {{ $r['nama'] }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                                {{ $r['nip'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- UNIT --}}
                                <td class="px-6 py-5">
                                    <span class="text-sm font-medium text-slate-600">
                                        {{ $r['unit'] }}
                                    </span>
                                </td>

                                {{-- TOTAL HARI KERJA --}}
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-slate-50 text-slate-700 ring-1 ring-slate-200">
                                        {{ $r['total_hari'] }} hari
                                    </span>
                                </td>

                                {{-- HADIR --}}
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                        {{ $r['hadir'] }} hari
                                    </span>
                                </td>

                                {{-- ALPHA --}}
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black
                                        {{ $r['alfa'] > 0 ? 'bg-rose-50 text-rose-700 ring-1 ring-rose-200' : 'bg-slate-50 text-slate-500 ring-1 ring-slate-200' }}">
                                        {{ $r['alfa'] }} hari
                                    </span>
                                </td>

                                {{-- % KEHADIRAN --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3 justify-center">
                                        <div class="w-20 bg-slate-100 rounded-full h-2 overflow-hidden">
                                            <div class="{{ $barColor }} h-2 rounded-full transition-all"
                                                 style="width: {{ $persen }}%"></div>
                                        </div>
                                        <span class="text-xs font-black {{ $textColor }} w-10 text-right">
                                            {{ $persen }}%
                                        </span>
                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <div class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-600 text-sm">Tidak ada data</p>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                Tidak ada rekapitulasi untuk periode yang dipilih.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($rekap->hasPages())
                <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/40">
                    {{ $rekap->withQueryString()->links() }}
                </div>
            @endif

        </div>

    </div>
</x-app-layout>