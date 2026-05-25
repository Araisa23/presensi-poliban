<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[#006fcf] text-[10px] font-black uppercase tracking-[0.3em] mb-1">Halo {{ Auth::user()->name }}!</p>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                Dashboard Monitoring Presensi
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Monitoring kehadiran pegawai secara realtime.</p>
        </div>
    </x-slot>

    <div class="py-15">

        {{-- CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Total Pegawai</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $totalPegawai }}</div>
                            <div class="mt-1 text-xs font-bold text-slate-500">Terdaftar</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center">👥</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-emerald-600">Hadir Hari Ini</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $hadirHariIni }}</div>
                            <div class="mt-1 text-xs font-bold text-emerald-600">Tercatat masuk</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">✅</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-rose-600">Belum Hadir</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $tidakHadir }}</div>
                            <div class="mt-1 text-xs font-bold text-rose-600">Belum tercatat</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center">⚠️</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Tren Kehadiran (6 Bulan Terakhir)</h3>
                    <div class="h-64 flex items-center justify-center border-2 border-dashed border-slate-100 rounded-xl">
                        <span class="text-slate-400 text-sm font-medium italic">Canvas Grafik Tren Presensi</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Status Kehadiran</h3>
                    <div class="flex flex-col items-center">
                        <div class="w-40 h-40 rounded-full border-8 border-indigo-100 border-t-indigo-600 mb-6"></div>
                        <div class="w-full space-y-3">
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-slate-500">Hadir</span>
                                <span class="text-slate-900">{{ $hadirHariIni }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-slate-500">Belum Hadir</span>
                                <span class="text-slate-900">{{ $tidakHadir }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>