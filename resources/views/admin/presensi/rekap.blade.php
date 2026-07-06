<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Rekapitulasi Presensi Bulanan') }}
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Export rekapitulasi kehadiran pegawai per bulan.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a href="{{ route('admin.presensi.export.excel', [
                    'export' => 'rekap',
                    'bulan' => request('bulan') ?? now()->month,
                    'tahun' => request('tahun') ?? now()->year,
                    'user_id' => request('user_id')
                ]) }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                        bg-emerald-600 text-white text-xs font-black
                        uppercase tracking-[0.18em]
                        shadow-sm hover:bg-emerald-700
                        hover:scale-[1.02] transition">

                    Export Excel
                </a>

                <a href="{{ route('admin.presensi.export.pdf', [
                    'export' => 'rekap',
                    'bulan' => request('bulan') ?? now()->month,
                    'tahun' => request('tahun') ?? now()->year,
                    'user_id' => request('user_id')
                ]) }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                        bg-rose-600 text-white text-xs font-black
                        uppercase tracking-[0.18em]
                        shadow-sm hover:bg-rose-700
                        hover:scale-[1.02] transition">

                    Export PDF
                </a>

            </div>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('admin.presensi.rekap') }}" class="mb-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft p-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    {{-- BULAN --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Bulan
                        </label>
                        <select name="bulan" 
                            class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Tahun
                        </label>
                        <select name="tahun" 
                            class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                            @for($i = 2024; $i <= 2030; $i++)
                                <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- PEGAWAI --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Pegawai
                        </label>
                        <select name="user_id" 
                            class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Pegawai</option>
                            @foreach($pegawaiList as $pegawai)
                                <option value="{{ $pegawai->user_id }}" {{ request('user_id') == $pegawai->user_id ? 'selected' : '' }}>
                                    {{ $pegawai->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)] hover:scale-[1.01] transition">
                            Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden">

            {{-- TABLE HEADER INFO --}}
            <div class="px-6 py-5 border-b border-slate-100 dark:border-white/10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">
                            Data Rekap —
                            <span class="text-[#006fcf]">
                                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                            </span>
                        </h3>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-50 dark:bg-white/5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-white/10">
                        {{ $totalPegawai }} pegawai
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 dark:border-white/10">
                                Pegawai
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 dark:border-white/10 text-center">
                                Unit Kerja
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 dark:border-white/10 text-center">
                                Hadir
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 dark:border-white/10 text-center">
                                Alfa
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100 dark:border-white/10 text-center">
                                Total Hari
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $item)
                            <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50/50 dark:hover:bg-white/5 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#004b8d] to-[#006fcf] flex items-center justify-center text-white font-black text-xs">
                                            {{ substr($item['nama'], 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 dark:text-white text-sm">
                                                {{ $item['nama'] }}
                                            </p>
                                            <p class="text-xs text-slate-400">
                                                {{ $item['nip'] }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300 text-sm font-medium">
                                    {{ $item['unit_kerja'] }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl bg-emerald-50/70 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 text-xs font-bold">
                                        {{ $item['hadir'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl bg-rose-50/70 dark:bg-rose-500/10 text-rose-700 dark:text-rose-300 text-xs font-bold">
                                        {{ $item['alfa'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300 text-sm font-medium">
                                    {{ $item['total_hari'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">
                                    Belum ada data rekapitulasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
