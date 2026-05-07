<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Admin Dashboard</p>
                <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Kontrol Administrator</h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">Ringkasan cepat dan akses manajemen utama sistem presensi.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2">
                <a href="{{ route('admin.presensi.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-slate-50 text-slate-700 font-black uppercase tracking-[0.18em] text-xs ring-1 ring-slate-900/10 shadow-soft hover:bg-slate-50/80 transition">
                    Data Presensi
                </a>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-gradient-to-b from-[#2f6aa8] to-[#214e83] text-white font-black uppercase tracking-[0.18em] text-xs shadow-[0_10px_20px_rgba(11,_44,_82,_0.18)] ring-1 ring-[#0b2c52]/20 transition active:scale-95">
                    Data Users
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Total Pegawai</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $totalPegawai }}</div>
                            <div class="mt-1 text-xs font-bold text-slate-500">Terdaftar</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center ring-1 ring-indigo-600/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Unit Kerja</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $totalUnit }}</div>
                            <div class="mt-1 text-xs font-bold text-slate-500">Aktif</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center ring-1 ring-blue-600/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Hadir Hari Ini</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $hadirHariIni }}</div>
                            <div class="mt-1 text-xs font-bold text-emerald-600">Tercatat</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center ring-1 ring-emerald-600/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-[10px] font-black uppercase tracking-[0.25em]">Pusat Manajemen</p>
                        <p class="mt-1 font-black">Menu Utama</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.pegawai.index') }}" class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 hover:border-indigo-500 hover:shadow-soft transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Kelola</p>
                        <p class="mt-1 font-black text-slate-900">Pegawai</p>
                    </a>
                    <a href="{{ route('admin.unit-kerja.index') }}" class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 hover:border-indigo-500 hover:shadow-soft transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Kelola</p>
                        <p class="mt-1 font-black text-slate-900">Unit Kerja</p>
                    </a>
                    <a href="{{ route('admin.jadwal-kerja.index') }}" class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 hover:border-indigo-500 hover:shadow-soft transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Kelola</p>
                        <p class="mt-1 font-black text-slate-900">Jadwal</p>
                    </a>
                    <a href="{{ route('admin.lokasi-kantor.index') }}" class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200 hover:border-indigo-500 hover:shadow-soft transition">
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Kelola</p>
                        <p class="mt-1 font-black text-slate-900">Lokasi</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200">
                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Ringkasan</p>
                    <p class="mt-1 font-black text-slate-900">Hari Ini</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-600">Total Pegawai</span>
                        <span class="text-sm font-black tabular-nums text-slate-900">{{ $totalPegawai }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-600">Unit Kerja</span>
                        <span class="text-sm font-black tabular-nums text-slate-900">{{ $totalUnit }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-600">Presensi Tercatat</span>
                        <span class="text-sm font-black tabular-nums text-emerald-700">{{ $hadirHariIni }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Shortcut</p>
                <div class="mt-4 grid grid-cols-1 gap-3">
                    <a href="{{ route('admin.hari-libur.index') }}" class="px-5 py-4 rounded-xl bg-slate-50/70 border border-slate-200 font-black text-slate-800 hover:border-indigo-500 transition">
                        Hari Libur
                    </a>
                    <a href="{{ route('admin.presensi.index') }}" class="px-5 py-4 rounded-xl bg-gradient-to-b from-[#2f6aa8] to-[#214e83] text-white font-black shadow-[0_10px_20px_rgba(11,_44,_82,_0.18)] ring-1 ring-[#0b2c52]/20 transition active:scale-95">
                        Data Presensi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

