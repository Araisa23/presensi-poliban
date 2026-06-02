<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Rekapitulasi Presensi Bulanan') }}
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Filter periode, lalu export laporan dalam Excel atau PDF.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">

                {{-- EXPORT EXCEL --}}
                <a
                    href="{{ route('pimpinan.rekap.excel', ['bulan'=>$bulan,'tahun'=>$tahun,'user_id'=>$userId]) }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                        bg-emerald-50 text-emerald-700
                        ring-1 ring-emerald-600/10
                        font-bold shadow-soft hover:bg-emerald-100 transition"
                >

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 4v12m0 0l-3-3m3 3l3-3"/>
                    </svg>

                    Export Excel

                </a>

                {{-- EXPORT PDF --}}
                <a
                    href="{{ route('pimpinan.rekap.pdf', ['bulan'=>$bulan,'tahun'=>$tahun,'user_id'=>$userId]) }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                        bg-rose-50 text-rose-700
                        ring-1 ring-rose-600/10
                        font-bold shadow-soft hover:bg-rose-100 transition"
                >

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 4v12m0 0l-3-3m3 3l3-3"/>
                    </svg>

                    Export PDF

                </a>

            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            <!-- Filter Rekap -->
            <form action="{{ route('pimpinan.rekap') }}" method="GET" class="mb-6">

                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft p-5">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                        {{-- BULAN --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                                Bulan
                            </label>

                            <select
                                name="bulan"
                                class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500"
                            >
                                @for($m=1; $m<=12; $m++)
                                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->monthName }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- TAHUN --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                                Tahun
                            </label>

                            <select
                                name="tahun"
                                class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500"
                            >
                                @for($y=date('Y'); $y>=2023; $y--)
                                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- PEGAWAI --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                                Pegawai
                            </label>

                            <select
                                name="user_id"
                                class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500"
                            >
                                <option value="">Semua Pegawai</option>

                                @foreach($pegawaiList as $p)
                                    <option value="{{ $p->user_id }}"
                                        {{ $userId == $p->user_id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)] hover:scale-[1.01] transition"
                            >
                                Filter
                            </button>

                        </div>

                    </div>

                </div>

            </form>
           
             <div class="mt-6 mb-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft p-5">

                <h4 class="font-black text-slate-800 dark:text-slate-100 mb-2">
                    Catatan Laporan
                </h4>

                <p class="text-sm text-slate-500 leading-relaxed">
                    Data rekapitulasi dihitung otomatis oleh sistem berdasarkan presensi yang telah tervalidasi pada periode yang dipilih.
                </p>

            </div>
            
            <!-- Table Rekap -->
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Pegawai</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Hadir</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Alfa</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Total Hari</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($rekap as $r)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">

                                    {{-- PEGAWAI --}}
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">

                                            <div class="w-11 h-11 rounded-2xl
                                                        bg-indigo-50/80
                                                        text-indigo-700
                                                        flex items-center justify-center
                                                        font-black text-lg mr-3
                                                        ring-1 ring-indigo-600/10 shadow-soft">

                                                {{ strtoupper(substr($r['nama'],0,1)) }}

                                            </div>

                                            <div>
                                                <div class="font-black text-slate-800 dark:text-slate-100">
                                                    {{ $r['nama'] }}
                                                </div>

                                                <div class="text-[10px] text-slate-400 font-mono">
                                                    {{ $r['nip'] ?? '-' }}
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    {{-- HADIR --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                                            {{ $r['hadir'] }}
                                        </span>
                                    </td>

                                    {{-- ALFA --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-rose-50 text-rose-700 ring-1 ring-rose-600/10">
                                            {{ $r['alfa'] }}
                                        </span>
                                    </td>

                                    {{-- TOTAL HARI --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-slate-50 text-slate-700 ring-1 ring-slate-600/10">
                                            {{ $r['total_hari'] }}
                                        </span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic font-medium">Data rekapitulasi belum tersedia untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        
    </div>
</x-app-layout>
