<div class="flex flex-col h-full">

    {{-- MENU --}}
    <nav class="px-3 pt-6 space-y-1 flex-1 overflow-y-auto">
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </span>
        Dashboard
    </a>

    {{-- ADMIN MENU --}}
    @if(Auth::user()->role->name == 'admin')

    <div x-data="{
        openUserMenu:
            {{ request()->routeIs('admin.pegawai.*')
                || request()->routeIs('admin.users.*')
                || request()->routeIs('admin.pimpinan.*')
                || request()->routeIs('manajemen-user.administrator')
                    ? 'true'
                    : 'false'
            }}
    }" class="space-y-1">

        {{-- BUTTON --}}
        <button
            @click="openUserMenu = !openUserMenu"
            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-bold
            {{ request()->routeIs('admin.pegawai.*')
                || request()->routeIs('admin.pimpinan.*')
                || request()->routeIs('manajemen-user.administrator')
                    ? 'bg-white/15 text-white ring-1 ring-white/20'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
        >
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
                    <svg class="w-4 h-4
                        {{ request()->routeIs('admin.pegawai.*')
                            || request()->routeIs('admin.pimpinan.*')
                            || request()->routeIs('manajemen-user.administrator')
                                ? 'text-white'
                                : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                Manajemen Pengguna
            </div>

            {{-- ARROW --}}
            <svg class="w-4 h-4 transition duration-200 text-slate-400"
                :class="{ 'rotate-180': openUserMenu }"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- DROPDOWN MENU --}}
        <div x-show="openUserMenu" x-transition x-cloak class="ml-5 mt-1 space-y-1">

            <a href="{{ route('admin.pegawai.index') }}"
                class="block px-4 py-2 rounded-xl text-sm font-semibold
                {{ request()->routeIs('admin.pegawai.*')
                    ? 'bg-white/15 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                Pegawai
            </a>

            <a href="{{ route('admin.pimpinan.index') }}"
                class="block px-4 py-2 rounded-xl text-sm font-semibold
                {{ request()->routeIs('admin.pimpinan.*')
                    ? 'bg-white/15 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                Pimpinan
            </a>

            <a href="{{ route('manajemen-user.administrator') }}"
                class="block px-4 py-2 rounded-xl text-sm font-semibold
                {{ request()->routeIs('manajemen-user.administrator')
                    ? 'bg-white/15 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                Administrator
            </a>
        </div>
    </div>

    <a href="{{ route('admin.unit-kerja.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.unit-kerja.*') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.unit-kerja.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </span>
        Unit Kerja
    </a>

    <a href="{{ route('admin.lokasi-kantor.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.lokasi-kantor.*') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.lokasi-kantor.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </span>
        Lokasi
    </a>

    <a href="{{ route('admin.jadwal-kerja.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.jadwal-kerja.*') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.jadwal-kerja.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
        </span>
        Jadwal
    </a>

    <a href="{{ route('admin.pengumuman.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.pengumuman.*') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.pengumuman.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5L6 9H2v6h4l5 4V5zM15.54 8.46a5 5 0 010 7.07M19.07 4.93a10 10 0 010 14.14"/></svg>
        </span>
        Pengumuman
    </a>

    <a href="{{ route('admin.kalender-akademik.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.kalender-akademik.*') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.kalender-akademik.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 6h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </span>
        Kalender
    </a>

    <a href="{{ route('admin.presensi.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.presensi.index') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.presensi.index') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6"/></svg>
        </span>
        Data Presensi
    </a>

    <a href="{{ route('admin.presensi.rekap') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.presensi.rekap') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 {{ request()->routeIs('admin.presensi.rekap') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6M3 7h18M3 12h18M3 17h18"/></svg>
        </span>
        Rekapitulasi Bulanan
    </a>

    <a href="{{ route('admin.device-logs.index') }}"
    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold 
    {{ request()->routeIs('admin.device-logs.*') 
            ? 'bg-white/15 text-white ring-1 ring-white/20' 
            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">

        <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
            <svg class="w-4 h-4 
            {{ request()->routeIs('admin.device-log.*') 
                ? 'text-white' 
                : 'text-slate-400' }}"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24">

                <path stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2"
                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>

                <path stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2"
                    d="M5.5 20a6.5 6.5 0 0113 0"/>
            </svg>
        </span>

        Log Device Ditolak
    </a>
    @endif

    @if(Auth::user()->role->name == 'pegawai')
        <a href="{{ route('pegawai.presensi.create') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pegawai.presensi.create') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 {{ request()->routeIs('pegawai.presensi.create') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A1 1 0 0120 13.118V17a2 2 0 01-2 2H6a2 2 0 01-2-2v-3.882a1 1 0 01.447-.842L9 10m6 0V8a3 3 0 00-6 0v2m6 0H9"/></svg>
            </span>
            Presensi
        </a>

        <a href="{{ route('pegawai.presensi.history') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pegawai.presensi.history') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 {{ request()->routeIs('pegawai.presensi.history') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
            </span>
            Riwayat
        </a>
    @endif

    @if(Auth::user()->role->name == 'pimpinan')
        <a href="{{ route('pimpinan.monitoring') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('pimpinan.monitoring') ? 'bg-white/15 text-white ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <span class="w-8 h-8 rounded-xl bg-white/10 ring-1 ring-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 {{ request()->routeIs('pimpinan.monitoring') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </span>
            Monitoring
        </a>
    @endif
</nav>

    {{-- LOGOUT — selalu di bawah --}}
    <div class="px-3 pb-6 pt-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-rose-400 hover:bg-rose-500/15 hover:text-rose-300 transition"
            >
                <span class="w-8 h-8 rounded-xl bg-rose-500/10 ring-1 ring-rose-500/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                Logout
            </button>
        </form>
    </div>

</div>