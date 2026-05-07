<aside class="hidden lg:flex lg:flex-col lg:w-72 bg-white border-r border-slate-200">
    <div class="h-14 px-4 flex items-center gap-3 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white">
        <div class="w-9 h-9 rounded-2xl bg-white/10 ring-1 ring-white/15 flex items-center justify-center font-black">
            P
        </div>
        <div class="leading-tight">
            <div class="text-sm font-black tracking-tight">PresenceHub</div>
            <div class="text-[10px] font-black uppercase tracking-[0.25em] text-white/70">Presensi</div>
        </div>
    </div>

    <div class="px-4 py-4">
        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Menu Navigasi</p>
    </div>

    <nav class="px-3 pb-6 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
            <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </span>
            Dashboard
        </a>

        @if(Auth::user()->role->name == 'admin')
            <a href="{{ route('admin.pegawai.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.pegawai.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.pegawai.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                Pegawai
            </a>

            <a href="{{ route('admin.unit-kerja.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.unit-kerja.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.unit-kerja.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </span>
                Unit Kerja
            </a>

            <a href="{{ route('admin.jadwal-kerja.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.jadwal-kerja.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.jadwal-kerja.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
                </span>
                Jadwal
            </a>

            <a href="{{ route('admin.hari-libur.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.hari-libur.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.hari-libur.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10"/></svg>
                </span>
                Hari Libur
            </a>

            <a href="{{ route('admin.lokasi-kantor.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.lokasi-kantor.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.lokasi-kantor.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                Lokasi
            </a>

            <a href="{{ route('admin.presensi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.presensi.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.presensi.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6"/></svg>
                </span>
                Data Presensi
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.users.*') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                Data Users
            </a>
        @endif

        @if(Auth::user()->role->name == 'pegawai')
            <a href="{{ route('pegawai.presensi.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pegawai.presensi.create') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('pegawai.presensi.create') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A1 1 0 0120 13.118V17a2 2 0 01-2 2H6a2 2 0 01-2-2v-3.882a1 1 0 01.447-.842L9 10m6 0V8a3 3 0 00-6 0v2m6 0H9"/></svg>
                </span>
                Presensi
            </a>

            <a href="{{ route('pegawai.presensi.history') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pegawai.presensi.history') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('pegawai.presensi.history') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
                </span>
                Riwayat
            </a>
        @endif

        @if(Auth::user()->role->name == 'pimpinan')
            <a href="{{ route('pimpinan.monitoring') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pimpinan.monitoring') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('pimpinan.monitoring') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </span>
                Monitoring
            </a>

            <a href="{{ route('pimpinan.laporan.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pimpinan.laporan.index') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('pimpinan.laporan.index') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6"/></svg>
                </span>
                Laporan Harian
            </a>

            <a href="{{ route('pimpinan.rekap') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pimpinan.rekap') ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span class="w-8 h-8 rounded-xl bg-white ring-1 ring-slate-900/10 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ request()->routeIs('pimpinan.rekap') ? 'text-indigo-700' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10"/></svg>
                </span>
                Rekap Bulanan
            </a>
        @endif
    </nav>
</aside>

