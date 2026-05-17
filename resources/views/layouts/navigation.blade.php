<nav x-data="{ open: false }"
class="lg:hidden sticky top-0 z-50 backdrop-blur-2xl bg-white/10 border-b border-white/10 shadow-xl">

    <div class="px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">

            <!-- LEFT -->
            <div class="flex items-center gap-3">

                <!-- MENU BUTTON -->
                <button
                    @click="open = ! open"
                    class="w-11 h-11 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white backdrop-blur-xl">

                    <svg class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            x-show="!open"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>

                        <path
                            x-show="open"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- LOGO -->
                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#6F9F4E] to-[#4d7434] flex items-center justify-center shadow-lg">

                        <span class="font-black text-white">
                            P
                        </span>

                    </div>

                    <div>
                        <h1 class="text-sm font-black text-white leading-tight">
                            Presensi Tendik Poliban
                        </h1>

                        <p class="text-[10px] uppercase tracking-[0.25em] text-white/60">
                            Presensi
                        </p>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                <div class="text-right">
                    <p class="text-sm font-bold text-white leading-tight">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/60">
                        {{ Auth::user()->role->name }}
                    </p>
                </div>

            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div
        x-show="open"
        x-transition
        class="px-4 pb-5 pt-2 space-y-2 bg-black/20 backdrop-blur-2xl border-t border-white/10">

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/10 text-white font-semibold">

            Dashboard
        </a>

        @if(Auth::user()->role->name == 'admin')

            <a href="{{ route('admin.pegawai.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Pegawai
            </a>

            <a href="{{ route('admin.unit-kerja.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Unit Kerja
            </a>

            <a href="{{ route('admin.jadwal-kerja.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Jadwal
            </a>

            <a href="{{ route('admin.presensi.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Presensi
            </a>

            <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Users
            </a>

        @endif

        @if(Auth::user()->role->name == 'pegawai')

            <a href="{{ route('pegawai.presensi.create') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Presensi
            </a>

            <a href="{{ route('pegawai.presensi.history') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Riwayat
            </a>

        @endif

        @if(Auth::user()->role->name == 'pimpinan')

            <a href="{{ route('pimpinan.monitoring') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Monitoring
            </a>

            <a href="{{ route('pimpinan.laporan.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Laporan
            </a>

        @endif

        <!-- PROFILE -->
        <div class="border-t border-white/10 pt-4 mt-4">

            <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white transition">
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full mt-2 flex items-center gap-3 px-4 py-3 rounded-2xl bg-red-500/20 hover:bg-red-500/30 text-red-200 transition">

                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>