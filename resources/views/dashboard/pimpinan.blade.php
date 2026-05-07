<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Pimpinan Dashboard</p>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                Monitoring Kehadiran
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Ringkasan cepat presensi hari ini dan akses laporan.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Total Pegawai</p>
                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900 dark:text-white">{{ $totalPegawai }}</div>
                                    <div class="mt-1 text-xs font-bold text-slate-500 dark:text-slate-300">Terdaftar</div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-700 flex items-center justify-center ring-1 ring-slate-900/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Hadir Hari Ini</p>
                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900 dark:text-white">{{ $hadirHariIni }}</div>
                                    <div class="mt-1 text-xs font-bold text-emerald-600">Tercatat masuk</div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center ring-1 ring-emerald-600/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Belum Hadir</p>
                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900 dark:text-white">{{ $tidakHadir }}</div>
                                    <div class="mt-1 text-xs font-bold text-rose-600">Belum tercatat</div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center ring-1 ring-rose-600/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white">Menu Laporan</h3>
                        <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-300">Akses monitoring, laporan harian, dan rekap bulanan.</p>
                        <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <a href="{{ route('pimpinan.monitoring') }}" class="inline-flex items-center justify-center px-5 py-4 rounded-2xl bg-white text-slate-700 font-black uppercase tracking-[0.18em] text-xs ring-1 ring-slate-900/10 shadow-soft hover:bg-slate-50 transition">
                                Monitoring
                            </a>
                            <a href="{{ route('pimpinan.laporan.index') }}" class="inline-flex items-center justify-center px-5 py-4 rounded-2xl bg-gradient-to-b from-emerald-600 to-emerald-700 text-white font-black uppercase tracking-[0.18em] text-xs shadow-[0_14px_30px_rgba(16,_185,_129,_0.25)] ring-1 ring-emerald-600/20 transition active:scale-95">
                                Laporan Harian
                            </a>
                            <a href="{{ route('pimpinan.rekap') }}" class="inline-flex items-center justify-center px-5 py-4 rounded-2xl bg-gradient-to-b from-amber-500 to-amber-600 text-white font-black uppercase tracking-[0.18em] text-xs shadow-[0_14px_30px_rgba(245,_158,_11,_0.25)] ring-1 ring-amber-600/20 transition active:scale-95">
                                Rekap Bulanan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Catatan</p>
                        <h4 class="mt-2 text-lg font-black text-slate-900 dark:text-white">Interpretasi</h4>
                        <ul class="mt-3 space-y-2 text-sm font-medium text-slate-600 dark:text-slate-300">
                            <li class="flex gap-2">
                                <span class="mt-2 w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span><span class="font-black">Hadir</span> = pegawai tercatat presensi masuk.</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="mt-2 w-2 h-2 rounded-full bg-rose-500"></span>
                                <span><span class="font-black">Belum hadir</span> = belum ada presensi masuk.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>