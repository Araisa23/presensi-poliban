<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Monitoring Kehadiran Realtime') }}
                </h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Pantau presensi per tanggal dengan ringkasan jam masuk/pulang.
                </p>
            </div>

            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                    bg-white text-[#0b3c70]
                    font-bold shadow-lg
                    hover:scale-[1.02] transition print:hidden"
            >
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

                Cetak Laporan
            </button>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('pimpinan.monitoring') }}" class="mb-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft p-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div class="md:col-span-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Pilih Tanggal Monitoring
                        </label>
                        <input type="date" name="tanggal" value="{{ $tanggal }}" 
                            class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)] hover:scale-[1.01] transition">
                            Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- TABLE DATA --}}
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
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">
                                {{-- PEGAWAI --}}
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="w-11 h-11 rounded-2xl bg-indigo-50/80 text-indigo-700 flex items-center justify-center font-black text-lg mr-3 ring-1 ring-indigo-600/10 shadow-soft">
                                            {{ strtoupper(substr($p->tenagaKependidikan->nama ?? ($p->user->name ?? 'P'), 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 dark:text-slate-100">
                                                {{ $p->tenagaKependidikan->nama ?? ($p->user->name ?? '-') }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-mono">
                                                {{ $p->tenagaKependidikan->nip ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- MASUK --}}
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                                        {{ $p->jam_masuk ?? '--:--' }}
                                    </span>
                                </td>

                                {{-- PULANG --}}
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-amber-50 text-amber-700 ring-1 ring-amber-600/10">
                                        {{ $p->jam_pulang ?? '--:--' }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
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
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center text-slate-400">
                                        <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="font-medium">Belum ada pegawai yang hadir pada tanggal ini.</p>
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