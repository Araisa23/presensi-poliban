<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Laporan</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Laporan Presensi') }}
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Ringkasan laporan presensi untuk pimpinan.</p>
            </div>
            <a href="{{ route('pimpinan.laporan.export') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-rose-600 to-rose-700 text-white shadow-[0_14px_30px_rgba(225,_29,_72,_0.25)] ring-1 ring-rose-600/20 transition">
                Export PDF
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 sm:px-0">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10 p-6 sm:p-8">
                <div class="flex items-start justify-between gap-6">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">Modul Laporan</h3>
                        <p class="mt-2 text-sm font-medium text-slate-500 dark:text-slate-400">Halaman ini bisa dipakai untuk ringkasan atau shortcut menuju laporan harian & rekap bulanan.</p>
                    </div>
                    <div class="hidden sm:flex w-14 h-14 rounded-3xl bg-gradient-to-tr from-indigo-600 to-sky-500 text-white items-center justify-center shadow-[0_16px_35px_rgba(79,_70,_229,_0.25)]">
                        <span class="text-xl font-black">LP</span>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('pimpinan.monitoring') }}" class="group p-6 rounded-3xl bg-slate-50/70 dark:bg-white/5 border border-slate-100/70 dark:border-white/10 shadow-soft hover:shadow-lift transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Realtime</p>
                        <p class="mt-2 text-lg font-black text-slate-800 dark:text-white">Monitoring</p>
                        <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">Pantau kehadiran per hari.</p>
                    </a>
                    <a href="{{ route('pimpinan.laporan.index') }}" class="group p-6 rounded-3xl bg-slate-50/70 dark:bg-white/5 border border-slate-100/70 dark:border-white/10 shadow-soft hover:shadow-lift transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Detail</p>
                        <p class="mt-2 text-lg font-black text-slate-800 dark:text-white">Laporan Harian</p>
                        <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">Detail hadir/alpha.</p>
                    </a>
                    <a href="{{ route('pimpinan.rekap') }}" class="group p-6 rounded-3xl bg-slate-50/70 dark:bg-white/5 border border-slate-100/70 dark:border-white/10 shadow-soft hover:shadow-lift transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Akumulasi</p>
                        <p class="mt-2 text-lg font-black text-slate-800 dark:text-white">Rekap Bulanan</p>
                        <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">Export Excel/PDF.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>