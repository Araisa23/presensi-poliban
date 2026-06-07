<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Rekapitulasi Presensi') }}
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Ringkasan kehadiran pegawai per bulan.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('pimpinan.rekap.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'user_id' => $userId]) }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                          bg-emerald-600 text-white
                          font-bold shadow-lg
                          hover:scale-[1.02] transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>

                    Export Excel
                </a>

                <a href="{{ route('pimpinan.rekap.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'user_id' => $userId]) }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                          bg-rose-600 text-white
                          font-bold shadow-lg
                          hover:scale-[1.02] transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-12 0h12v4H6v-4z"/>
                    </svg>

                    Export PDF
                </a>
            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- FILTER --}}
        <form action="{{ route('pimpinan.rekap') }}" method="GET" class="mb-6">

            <div class="bg-white dark:bg-slate-900 rounded-3xl
                        border border-slate-100/70 dark:border-white/10
                        shadow-soft p-5">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Bulan
                        </label>

                        <select name="bulan"
                                class="w-full rounded-2xl border-slate-200
                                       dark:border-white/10
                                       bg-white dark:bg-white/5
                                       px-4 py-3 text-sm font-medium
                                       text-slate-700 dark:text-slate-100
                                       focus:ring-2 focus:ring-indigo-500">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->monthName }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Tahun
                        </label>

                        <select name="tahun"
                                class="w-full rounded-2xl border-slate-200
                                       dark:border-white/10
                                       bg-white dark:bg-white/5
                                       px-4 py-3 text-sm font-medium
                                       text-slate-700 dark:text-slate-100
                                       focus:ring-2 focus:ring-indigo-500">
                            @for($i = 2024; $i <= 2030; $i++)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Pegawai
                        </label>

                        <select name="user_id"
                                class="w-full rounded-2xl border-slate-200
                                       dark:border-white/10
                                       bg-white dark:bg-white/5
                                       px-4 py-3 text-sm font-medium
                                       text-slate-700 dark:text-slate-100
                                       focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Pegawai</option>
                            @foreach($pegawaiList as $pegawai)
                                <option value="{{ $pegawai->user_id }}" {{ $userId == $pegawai->user_id ? 'selected' : '' }}>
                                    {{ $pegawai->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center
                                   px-5 py-3 rounded-2xl font-black text-xs
                                   uppercase tracking-[0.18em]
                                   bg-gradient-to-r from-[#004b8d] to-[#006fcf]
                                   text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)]
                                   hover:scale-[1.01] transition"
                        >
                            Filter
                        </button>
                    </div>

                </div>

            </div>

        </form>

        {{-- TABLE REKAP --}}
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Pegawai</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Unit Kerja</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Total Hari Kerja</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Hadir</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Alpha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                        @forelse($rekap as $r)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-11 h-11 rounded-2xl
                                                    bg-indigo-50/80
                                                    text-indigo-700
                                                    flex items-center justify-center
                                                    font-black text-lg mr-3
                                                    ring-1 ring-indigo-600/10 shadow-soft">

                                            {{ strtoupper(substr($r['nama'], 0, 1)) }}

                                        </div>

                                        <div>

                                            <div class="font-black text-slate-800 dark:text-slate-100">
                                                {{ $r['nama'] }}
                                            </div>

                                            <div class="text-[10px] text-slate-400 font-mono">
                                                {{ $r['nip'] }}
                                            </div>

                                        </div>

                                    </div>

                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-slate-700 dark:text-slate-100">
                                        {{ $r['unit'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-slate-50 text-slate-700 ring-1 ring-slate-600/10">
                                        {{ $r['total_hari'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                                        {{ $r['hadir'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-rose-50 text-rose-700 ring-1 ring-rose-600/10">
                                        {{ $r['alfa'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">

                                    <div class="flex flex-col items-center text-slate-400">

                                        <svg class="w-16 h-16 mb-4 opacity-50"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 17v-2a4 4 0 014-4h4"/>
                                        </svg>

                                        <p class="font-medium">
                                            Tidak ada data rekapitulasi untuk periode yang dipilih.
                                        </p>

                                    </div>

                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
