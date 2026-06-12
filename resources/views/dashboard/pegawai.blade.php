<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-6">
            <div>
                <p class="text-[#006fcf] text-[10px] font-black uppercase tracking-[0.3em] mb-1">
                    Halo {{ Auth::user()->name }}!
                </p>
                <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                    Selamat Datang di Dashboard Pegawai.
                </h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Silahkan lakukan Presensi Harian Anda.
                </p>
            </div>
            {{-- RIGHT --}}
            <div class="flex items-center gap-2">

                <div class="bg-white rounded-2xl px-5 py-2 shadow-sm border border-slate-200">

                    <div
                        id="date-now"
                        class="mt-1 text-sm font-bold text-slate-800"
                    >
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>

                    <div
                        id="clock"
                        class="text-[#006fcf] font-black text-lg tabular-nums"
                    >
                        --:--:--
                    </div>
                </div>

            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ===== LEFT ===== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- PENGUMUMAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-xl font-black text-slate-800">Pengumuman Terbaru</h3>
                            <p class="text-sm text-slate-500 mt-1">Informasi terbaru untuk pegawai.</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#006fcf] flex items-center justify-center ring-1 ring-blue-600/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-3 max-h-[320px] overflow-y-auto pr-1"
                         x-data="{ openModal: false, selectedId: null }">

                            @forelse($pengumumans as $pengumuman)

                                <div class="p-4 rounded-2xl border border-slate-200 hover:border-blue-300 transition cursor-pointer"
                                     @click="selectedPengumuman = {{ $pengumuman->id }}; openModal = true">

                                    <div class="flex items-start justify-between gap-4">

                                        <div>
                                            <h4 class="font-bold text-slate-800 hover:text-blue-600 transition">
                                                {{ $pengumuman->judul }}
                                            </h4>
                                        </div>

                                        <span class="text-xs text-slate-400 whitespace-nowrap">
                                            {{ $pengumuman->created_at->translatedFormat('d F Y') }}
                                        </span>

                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 text-sm">
                                Belum ada pengumuman.
                            </div>
                        @endforelse

                        {{-- MODAL --}}
                        <div x-show="openModal"
                             x-transition
                             class="fixed inset-0 z-50 flex items-center justify-center p-4"
                             style="display:none;">

                            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                 @click="openModal = false"></div>

                            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden"
                                 @click.stop>
                                <div class="p-6">
                                    @foreach($pengumumans as $pengumuman)
                                        <template x-if="selectedId === {{ $pengumuman->id }}">
                                            <div>
                                                <h3 class="text-xl font-black text-slate-900 mb-4">
                                                    {{ $pengumuman->judul }}
                                                </h3>
                                                <div class="space-y-4">
                                                    <div>
                                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-1">Deskripsi</p>
                                                        <p class="text-sm text-slate-700 leading-relaxed">{{ $pengumuman->isi }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-1">Tanggal</p>
                                                        <p class="text-sm text-slate-700">
                                                            {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    @endforeach

                                    <div class="mt-6">
                                        <button @click="openModal = false"
                                                class="w-full px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em]
                                                       bg-gradient-to-r from-[#004b8d] to-[#006fcf]
                                                       text-white hover:opacity-90 transition">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- MASUK & PULANG --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- MASUK --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Masuk</p>
                                <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                                    {{ $presensiHariIni ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i') : '--:--' }}
                                </div>
                                <div class="mt-1 text-xs font-bold {{ $presensiHariIni ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ $presensiHariIni ? 'Tercatat' : 'Belum presensi' }}
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center ring-1 ring-emerald-600/10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- PULANG --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Pulang</p>
                                <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                                    {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? \Carbon\Carbon::parse($presensiHariIni->jam_pulang)->format('H:i') : '--:--' }}
                                </div>
                                <div class="mt-1 text-xs font-bold {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'text-amber-600' : 'text-slate-400' }}">
                                    {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'Tercatat' : 'Belum presensi pulang' }}
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center ring-1 ring-amber-600/10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ===== RIGHT: KALENDER MINI ===== --}}
            <div
                x-data="miniCalendar()"
                x-init="init()"
                class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 h-fit"
            >

                {{-- HEADER --}}
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Kalender Akademik</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Jadwal kegiatan akademik.</p>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                {{-- NAVIGASI BULAN --}}
                <div class="flex items-center justify-between mb-4">
                    <button
                        @click="prevMonth()"
                        class="w-8 h-8 rounded-xl flex items-center justify-center
                               text-slate-500 hover:bg-slate-100 hover:text-slate-800
                               transition font-bold text-lg leading-none">
                        ‹
                    </button>

                    <h4 class="font-black text-slate-800 text-sm" x-text="monthLabel"></h4>

                    <button
                        @click="nextMonth()"
                        class="w-8 h-8 rounded-xl flex items-center justify-center
                               text-slate-500 hover:bg-slate-100 hover:text-slate-800
                               transition font-bold text-lg leading-none">
                        ›
                    </button>
                </div>

                {{-- NAMA HARI --}}
                <div class="grid grid-cols-7 text-center text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">
                    <div>Min</div>
                    <div>Sen</div>
                    <div>Sel</div>
                    <div>Rab</div>
                    <div>Kam</div>
                    <div>Jum</div>
                    <div>Sab</div>
                </div>

                {{-- GRID TANGGAL + DOT (satu grid, dot absolute di dalam button) --}}
                <div class="grid grid-cols-7 gap-1">

                    {{-- OFFSET --}}
                    <template x-for="_ in firstDayOffset" :key="'e-' + _">
                        <div></div>
                    </template>

                    {{-- TANGGAL --}}
                    <template x-for="day in daysInMonth" :key="day">
                        <button
                            type="button"
                            @click="selectDate(day)"
                            class="relative h-9 w-full rounded-xl flex flex-col items-center justify-center
                                   text-xs font-semibold transition pb-1"
                            :class="{
                                'bg-[#006fcf] text-white shadow-sm': isToday(day),
                                'bg-blue-50 text-[#0b3c70] font-black ring-1 ring-[#006fcf]/30': selected === day && !isToday(day),
                                'text-rose-400 hover:bg-rose-50': !isToday(day) && isWeekend(day) && selected !== day,
                                'text-slate-600 hover:bg-slate-100': !isToday(day) && !isWeekend(day) && selected !== day,
                            }"
                        >
                            <span x-text="day"></span>
                            {{-- DOT EVENT --}}
                            <template x-if="hasEvent(day)">
                                <span class="absolute bottom-1 w-1 h-1 rounded-full"
                                      :class="isToday(day) ? 'bg-white/80' : 'bg-orange-400'">
                                </span>
                            </template>
                        </button>
                    </template>

                </div>

                {{-- EVENT DETAIL --}}
                <div class="mt-4 border-t border-slate-100 pt-4 min-h-[80px]">

                    <template x-if="selectedEvents.length > 0">
                        <div class="space-y-2">
                            <template x-for="event in selectedEvents" :key="event.id">
                                <div class="p-3 rounded-2xl border border-slate-200 bg-slate-50">
                                    <div class="flex items-start gap-2.5">
                                        <span class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0"
                                              :class="event.jenis === 'nasional' ? 'bg-rose-400' : 'bg-[#006fcf]'">
                                        </span>
                                        <div>
                                            <p class="font-bold text-xs text-slate-800" x-text="event.judul"></p>
                                            <p class="text-[10px] text-slate-400 mt-0.5" x-text="event.tanggal_mulai"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="selected && selectedEvents.length === 0">
                        <div class="flex flex-col items-center justify-center py-4 text-slate-400">
                            <svg class="w-8 h-8 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-center">Tidak ada agenda pada tanggal ini.</p>
                        </div>
                    </template>

                    <template x-if="!selected">
                        <p class="text-xs text-slate-400 text-center pt-4">
                            Pilih tanggal untuk melihat agenda.
                        </p>
                    </template>

                </div>

            </div>

        </div>
    </div>

    <script>
        // ========================
        // MINI CALENDAR ALPINE
        // ========================
        function miniCalendar() {
            return {
                // Data events dari Laravel
                events: @json($kalenders),

                // State bulan & tahun yang sedang ditampilkan
                currentYear:  {{ now()->year }},
                currentMonth: {{ now()->month }}, // 1-12

                // State tanggal dipilih
                selected: null,
                selectedEvents: [],

                // Computed properties
                get monthLabel() {
                    const date = new Date(this.currentYear, this.currentMonth - 1, 1);
                    return date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                },

                get daysInMonth() {
                    const count = new Date(this.currentYear, this.currentMonth, 0).getDate();
                    return Array.from({ length: count }, (_, i) => i + 1);
                },

                // Offset: hari pertama bulan ini jatuh di kolom ke berapa (0=Min, 6=Sab)
                get firstDayOffset() {
                    const offset = new Date(this.currentYear, this.currentMonth - 1, 1).getDay();
                    return Array.from({ length: offset }, (_, i) => i);
                },

                init() {
                    // Otomatis pilih hari ini kalau bulan aktif = bulan sekarang
                    const now = new Date();
                    if (
                        this.currentMonth === now.getMonth() + 1 &&
                        this.currentYear  === now.getFullYear()
                    ) {
                        this.selectDate(now.getDate());
                    }
                },

                prevMonth() {
                    if (this.currentMonth === 1) {
                        this.currentMonth = 12;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.selected       = null;
                    this.selectedEvents = [];
                },

                nextMonth() {
                    if (this.currentMonth === 12) {
                        this.currentMonth = 1;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.selected       = null;
                    this.selectedEvents = [];
                },

                // Format tanggal dari day integer ke 'YYYY-MM-DD'
                toDateString(day) {
                    const mm = String(this.currentMonth).padStart(2, '0');
                    const dd = String(day).padStart(2, '0');
                    return `${this.currentYear}-${mm}-${dd}`;
                },

                isToday(day) {
                    const now = new Date();
                    return (
                        day              === now.getDate()      &&
                        this.currentMonth === now.getMonth() + 1 &&
                        this.currentYear  === now.getFullYear()
                    );
                },

                isWeekend(day) {
                    const d = new Date(this.currentYear, this.currentMonth - 1, day).getDay();
                    return d === 0 || d === 6; // 0=Minggu, 6=Sabtu
                },

                hasEvent(day) {
                    const check = this.toDateString(day);
                    return this.events.some(event => {
                        const end = event.tanggal_selesai || event.tanggal_mulai;
                        return check >= event.tanggal_mulai && check <= end;
                    });
                },

                selectDate(day) {
                    this.selected = day;
                    const check   = this.toDateString(day);
                    this.selectedEvents = this.events.filter(event => {
                        const end = event.tanggal_selesai || event.tanggal_mulai;
                        return check >= event.tanggal_mulai && check <= end;
                    });
                },
            };
        }

        // ========================
        // CLOCK
        // ========================
        function updateClock() {
            const now  = new Date();
            const time = now.toLocaleTimeString('id-ID', { hour12: false });
            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: '2-digit', month: 'long', year: 'numeric'
            });

            document.getElementById('clock').textContent    = time;
            document.getElementById('date-now').textContent = date;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

</x-app-layout>