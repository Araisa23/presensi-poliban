<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Monitoring</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Monitoring Kehadiran Realtime') }}
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Pantau presensi per tanggal dengan ringkasan jam masuk/pulang.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            <!-- Filter Tanggal -->
            <div class="mb-6 bg-white dark:bg-slate-900 rounded-3xl shadow-soft border border-slate-100/70 dark:border-white/10 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-white/70 text-[10px] font-black uppercase tracking-[0.25em]">Pantau Tanggal</p>
                    <h3 class="text-xl font-black mt-1">{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</h3>
                </div>
                <form action="{{ route('pimpinan.monitoring') }}" method="GET" class="flex items-center space-x-2">
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="border-white/20 bg-white/95 text-slate-900 focus:border-indigo-300 focus:ring-indigo-300 rounded-2xl shadow-soft ring-1 ring-white/20 transition text-sm">
                    <button type="submit" class="px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white text-slate-800 shadow-soft ring-1 ring-white/40 transition hover:bg-white/90">Filter</button>
                </form>
                </div>
            </div>

            <!-- Monitoring Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($presensi as $p)
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft relative overflow-hidden group">
                        <!-- Background Accent -->
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-125 transition-transform">
                            <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-white/70 dark:bg-white/5 rounded-3xl flex items-center justify-center font-black text-slate-600 dark:text-slate-200 ring-1 ring-slate-900/5 dark:ring-white/10 shadow-soft">
                                {{ substr($p->tenagaKependidikan->nama ?? ($p->user->name ?? 'U'), 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight">{{ $p->tenagaKependidikan->nama ?? ($p->user->name ?? '-') }}</h4>
                                <p class="text-xs text-slate-400 font-mono">{{ $p->tenagaKependidikan->nip ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4 border-t border-slate-100/70 dark:border-white/10">
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mb-1">Masuk</p>
                                <p class="text-xl font-black text-emerald-700 dark:text-emerald-200 tabular-nums">{{ $p->jam_masuk ?? '--:--' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mb-1">Pulang</p>
                                <p class="text-xl font-black text-amber-700 dark:text-amber-200 tabular-nums">{{ $p->jam_pulang ?? '--:--' }}</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100/70 dark:border-white/10">
                             <div class="flex items-center space-x-1">
                                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-[10px] font-mono text-gray-500">Lat: {{ round($p->lat, 4) }}, Lng: {{ round($p->lng, 4) }}</span>
                             </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 py-20 text-center">
                         <div class="text-gray-300 dark:text-gray-600 mb-2">
                             <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                         </div>
                         <p class="text-gray-400 italic">Belum ada pegawai yang hadir pada tanggal ini.</p>
                    </div>
                @endforelse
            </div>
    </div>
</x-app-layout>
