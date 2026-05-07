<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Presensi</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Riwayat Presensi Saya') }}
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Rekaman presensi masuk dan pulang Anda.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Tanggal</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Masuk</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Pulang</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($presensi as $p)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                    <td class="px-6 py-5 font-black text-slate-800 dark:text-slate-100 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1.5 bg-emerald-50/80 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-200 rounded-2xl font-black tracking-widest ring-1 ring-emerald-600/10">
                                            {{ $p->jam_masuk ?? '--:--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1.5 bg-amber-50/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-200 rounded-2xl font-black tracking-widest ring-1 ring-amber-600/10">
                                            {{ $p->jam_pulang ?? '--:--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php $telat = false; @endphp {{-- Logic simplified for view --}}
                                        @if($p->jam_masuk)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-50/80 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-200 ring-1 ring-indigo-600/10">Tercatat</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-rose-50/80 dark:bg-rose-500/10 text-rose-700 dark:text-rose-200 ring-1 ring-rose-600/10">Alpha</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada riwayat presensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5">
                    {{ $presensi->links() }}
                </div>
            </div>
    </div>
</x-app-layout>