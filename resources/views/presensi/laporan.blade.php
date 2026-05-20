<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Laporan</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Laporan Harian') }}
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Detail kehadiran pegawai pada tanggal terpilih.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            <!-- Filter Laporan -->
            <div class="mb-6 bg-white dark:bg-slate-900 rounded-3xl shadow-soft border border-slate-100/70 dark:border-white/10 overflow-hidden print:hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <p class="text-black-70 text-[10px] font-black uppercase tracking-[0.25em] leading-loose">Detail Kehadiran</p>
                        <h3 class="text-xl font-black">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM YYYY') }}</h3>
                    </div>
                    <form action="{{ route('pimpinan.laporan.index') }}" method="GET" class="flex items-center space-x-2">
                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="border-white/20 bg-white/95 text-slate-900 focus:border-indigo-300 focus:ring-indigo-300 rounded-2xl shadow-soft ring-1 ring-white/20 transition text-sm">
                        <button type="submit" class="px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white text-slate-800 shadow-soft ring-1 ring-white/40 transition hover:bg-white/90">Tampilkan</button>
                        <button type="button" onclick="window.print()" class="px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white/10 text-white shadow-soft ring-1 ring-white/20 transition hover:bg-white/15">Cetak</button>
                    </form>
                </div>
            </div>

            <!-- Table Laporan -->
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Pegawai</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Jam Masuk</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Jam Pulang</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($presensi as $p)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-black text-slate-800 dark:text-slate-100">{{ $p->tenagaKependidikan->nama ?? ($p->user->name ?? '-') }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono tracking-tighter">{{ $p->tenagaKependidikan->nip ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-base font-black tabular-nums {{ $p->jam_masuk ? 'text-slate-800 dark:text-slate-100' : 'text-slate-300' }}">
                                            {{ $p->jam_masuk ?? '--:--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-base font-black tabular-nums {{ $p->jam_pulang ? 'text-slate-800 dark:text-slate-100' : 'text-slate-300' }}">
                                            {{ $p->jam_pulang ?? '--:--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($p->jam_masuk)
                                            <span class="px-3 py-1.5 bg-emerald-50/80 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-200 rounded-full text-[10px] font-black uppercase tracking-[0.2em] ring-1 ring-emerald-600/10">Hadir</span>
                                        @else
                                            <span class="px-3 py-1.5 bg-rose-50/80 dark:bg-rose-500/10 text-rose-700 dark:text-rose-200 rounded-full text-[10px] font-black uppercase tracking-[0.2em] ring-1 ring-rose-600/10">Alpha</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic font-medium">Tidak ada data kehadiran untuk tanggal yang dipilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</x-app-layout>
