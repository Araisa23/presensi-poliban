<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white border-b border-white/10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-2xl bg-white/10 shadow-soft ring-1 ring-white/15">
                                <x-application-logo class="block h-6 w-auto fill-current text-white" />
                            </div>
                            <span class="hidden sm:block font-black tracking-tight">PresenceHub</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role->name == 'admin')
                        <x-nav-link :href="route('admin.pegawai.index')" :active="request()->routeIs('admin.pegawai.*')">
                            {{ __('Pegawai') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.unit-kerja.index')" :active="request()->routeIs('admin.unit-kerja.*')">
                            {{ __('Unit Kerja') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.jadwal-kerja.index')" :active="request()->routeIs('admin.jadwal-kerja.*')">
                            {{ __('Jadwal') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.hari-libur.index')" :active="request()->routeIs('admin.hari-libur.*')">
                            {{ __('Hari Libur') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.lokasi-kantor.index')" :active="request()->routeIs('admin.lokasi-kantor.*')">
                            {{ __('Lokasi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.presensi.index')" :active="request()->routeIs('admin.presensi.*')">
                            {{ __('Data Presensi') }}
                        </x-nav-link>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('Data Users') }}
                            </x-nav-link>
                    @endif

                    @if(Auth::user()->role->name == 'pegawai')
                        <x-nav-link :href="route('pegawai.presensi.create')" :active="request()->routeIs('pegawai.presensi.create')">
                            {{ __('Presensi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pegawai.presensi.history')" :active="request()->routeIs('pegawai.presensi.history')">
                            {{ __('Riwayat') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role->name == 'pimpinan')
                        <x-nav-link :href="route('pimpinan.monitoring')" :active="request()->routeIs('pimpinan.monitoring')">
                            {{ __('Monitoring') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pimpinan.laporan.index')" :active="request()->routeIs('pimpinan.laporan.index')">
                            {{ __('Laporan Harian') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pimpinan.rekap')" :active="request()->routeIs('pimpinan.rekap')">
                            {{ __('Rekap Bulanan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 text-sm font-bold rounded-2xl text-white bg-white/10 hover:bg-white/15 ring-1 ring-white/15 shadow-soft focus:outline-none focus:ring-2 focus:ring-white/60 focus:ring-offset-2 focus:ring-offset-transparent transition">
                            <span class="max-w-[160px] truncate">{{ Auth::user()->name }}</span>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-2xl text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft focus:outline-none focus:ring-2 focus:ring-white/60 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white/10">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role->name == 'admin')
                <x-responsive-nav-link :href="route('admin.pegawai.index')" :active="request()->routeIs('admin.pegawai.*')">
                    {{ __('Pegawai') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.unit-kerja.index')" :active="request()->routeIs('admin.unit-kerja.*')">
                    {{ __('Unit Kerja') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jadwal-kerja.index')" :active="request()->routeIs('admin.jadwal-kerja.*')">
                    {{ __('Jadwal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.hari-libur.index')" :active="request()->routeIs('admin.hari-libur.*')">
                    {{ __('Hari Libur') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role->name == 'pegawai')
                <x-responsive-nav-link :href="route('pegawai.presensi.create')" :active="request()->routeIs('pegawai.presensi.create')">
                    {{ __('Presensi') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role->name == 'pimpinan')
                <x-responsive-nav-link :href="route('pimpinan.monitoring')" :active="request()->routeIs('pimpinan.monitoring')">
                    {{ __('Monitoring') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pimpinan.laporan.index')" :active="request()->routeIs('pimpinan.laporan.index')">
                    {{ __('Laporan Harian') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pimpinan.rekap')" :active="request()->routeIs('pimpinan.rekap')">
                    {{ __('Rekap Bulanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/15">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white/70">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
