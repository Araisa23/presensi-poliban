<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Rekap</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Rekapitulasi Presensi Bulanan') }}
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Filter periode, lalu export laporan dalam Excel atau PDF.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            <!-- Filter Rekap -->
            <div class="mb-6 bg-white dark:bg-slate-900 rounded-3xl shadow-soft border border-slate-100/70 dark:border-white/10 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white">
                    <p class="text-black-70 text-[10px] font-black uppercase tracking-[0.25em]">Filter Periode</p>
                    <h3 class="text-xl font-black mt-1">{{ \Carbon\Carbon::create()->month($bulan)->monthName }} {{ $tahun }}</h3>
                </div>
                <div class="p-6">
                <form action="{{ route('pimpinan.rekap') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <x-input-label for="bulan" :value="__('Bulan')" />
                        <select name="bulan" id="bulan" class="mt-2 block w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition text-sm">
                            @for($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->monthName }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <x-input-label for="tahun" :value="__('Tahun')" />
                        <select name="tahun" id="tahun" class="mt-2 block w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition text-sm">
                            @for($y=date('Y'); $y>=2023; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <x-input-label for="user_id" :value="__('Filter Pegawai (Opsional)')" />
                        <select name="user_id" id="user_id" class="mt-2 block w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition text-sm">
                            <option value="">Semua Pegawai</option>
                            @foreach($pegawaiList as $p)
                                <option value="{{ $p->user_id }}" {{ $userId == $p->user_id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-1 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-indigo-600 to-indigo-700 text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition">Tampilkan</button>
                    </div>
                </form>
                
                <div class="mt-6 flex flex-wrap gap-2 border-t border-slate-100/70 dark:border-white/10 pt-6">
                    <a href="{{ route('pimpinan.rekap.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'user_id' => $userId]) }}" class="px-6 py-3 bg-gradient-to-b from-emerald-600 to-emerald-700 hover:to-emerald-800 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition flex items-center ring-1 ring-emerald-600/20 shadow-[0_14px_30px_rgba(5,_150,_105,_0.25)]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export Excel
                    </a>
                    <a href="{{ route('pimpinan.rekap.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'user_id' => $userId]) }}" class="px-6 py-3 bg-gradient-to-b from-rose-600 to-rose-700 hover:to-rose-800 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition flex items-center ring-1 ring-rose-600/20 shadow-[0_14px_30px_rgba(225,_29,_72,_0.25)]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Export PDF
                    </a>
                </div>
            </div>
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
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-black text-slate-800 dark:text-slate-100">{{ $r['nama'] }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono tracking-tighter">{{ $r['nip'] ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-black text-emerald-700 dark:text-emerald-200 text-lg tabular-nums">
                                        {{ $r['hadir'] }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-black text-rose-700 dark:text-rose-200 text-lg tabular-nums">
                                        {{ $r['alfa'] }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1.5 bg-white/70 dark:bg-white/5 rounded-full font-black text-slate-600 dark:text-slate-300 ring-1 ring-slate-900/5 dark:ring-white/10 tabular-nums">
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
            
            <div class="mt-6 p-6 bg-white dark:bg-slate-900 border border-slate-100/70 dark:border-white/10 rounded-3xl text-xs leading-relaxed shadow-soft">
                <strong>Catatan Laporan:</strong> Data rekapitulasi dihitung secara otomatis oleh sistem pada akhir bulan. Pastikan sinkronisasi data presensi harian telah selesai sebelum mencetak laporan ini.
            </div>
    </div>
</x-app-layout>
