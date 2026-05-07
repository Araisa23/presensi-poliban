<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-6">
            <div>
                <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Pegawai Dashboard</p>
                <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                    Halo, {{ explode(' ', Auth::user()->name)[0] }}.
                </h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Ringkasan presensi hari ini.
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 ring-1 ring-slate-900/10">
                <div class="w-10 h-10 rounded-2xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="leading-tight" x-data="{
                    time: '',
                    date: '',
                    updateTime() {
                        const now = new Date();
                        this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        this.date = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                    }
                }" x-init="updateTime(); setInterval(() => updateTime(), 1000)">
                    <div class="font-black tabular-nums text-slate-900 text-lg" x-text="time"></div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500" x-text="date"></div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Masuk</p>
                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900 dark:text-white">
                                        {{ $presensiHariIni ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i') : '--:--' }}
                                    </div>
                                    <div class="mt-1 text-xs font-bold {{ $presensiHariIni ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $presensiHariIni ? 'Tercatat' : 'Belum presensi' }}
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center ring-1 ring-emerald-600/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Pulang</p>
                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900 dark:text-white">
                                        {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? \Carbon\Carbon::parse($presensiHariIni->jam_pulang)->format('H:i') : '--:--' }}
                                    </div>
                                    <div class="mt-1 text-xs font-bold {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'text-amber-600' : 'text-slate-400' }}">
                                        {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'Tercatat' : 'Belum presensi pulang' }}
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center ring-1 ring-amber-600/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white">Aksi Cepat</h3>
                                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-300">Ambil presensi atau lihat riwayat Anda.</p>
                            </div>
                        </div>
                        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="{{ route('pegawai.presensi.create') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-gradient-to-b from-indigo-600 to-indigo-700 text-white font-black uppercase tracking-[0.18em] text-xs shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition active:scale-95">
                                Presensi Sekarang
                            </a>
                            <a href="{{ route('pegawai.presensi.history') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white text-slate-700 font-black uppercase tracking-[0.18em] text-xs ring-1 ring-slate-900/10 shadow-soft hover:bg-slate-50 transition">
                                Riwayat Presensi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white">Profil</h3>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Nama</span>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-100 text-right">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">NIP</span>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-100 text-right">{{ Auth::user()->tenagaKependidikan->nip ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Unit</span>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-100 text-right">{{ Auth::user()->tenagaKependidikan->unitKerja->nama_unit ?? '-' }}</span>
                            </div>
                        </div>

                        @if(!auth()->user()->tenagaKependidikan)
                            <div class="mt-5 rounded-2xl bg-rose-50 text-rose-800 ring-1 ring-rose-600/10 p-4 text-sm font-bold">
                                Anda belum terhubung ke data pegawai.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>