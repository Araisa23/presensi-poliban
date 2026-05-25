<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-6">
            <div>
                <p class="text-[#006fcf] text-[10px] font-black uppercase tracking-[0.3em] mb-1">Halo {{ Auth::user()->name }}!</p>

                <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                    Selamat Datang di Dashboard Pegawai.
                </h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Silahkan lakukan Presensi Harian Anda.
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

    <div class="space-y-8">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- =========================
                    LEFT CONTENT
                ========================== --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- PENGUMUMAN --}}
                    <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">

                        <div class="flex items-center justify-between mb-5">

                            <div>
                                <h3 class="text-xl font-black text-slate-800">
                                    Pengumuman Terbaru
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Informasi terbaru untuk pegawai.
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center ring-1 ring-blue-600/10">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 13V6a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2h10a2 2 0 002-2v-4" />
                                </svg>

                            </div>

                        </div>

                        <div class="space-y-4 max-h-[350px] overflow-y-auto pr-2">

                            @forelse($pengumumans as $pengumuman)

                                <div class="p-4 rounded-2xl border border-slate-200 hover:border-blue-300 transition">

                                    <div class="flex items-start justify-between gap-4">

                                        <div>
                                            <h4 class="font-bold text-slate-800">
                                                {{ $pengumuman->judul }}
                                            </h4>

                                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                                {{ $pengumuman->isi }}
                                            </p>
                                        </div>

                                        <span class="text-xs text-slate-400 whitespace-nowrap">
                                            {{ $pengumuman->created_at->format('d M Y') }}
                                        </span>

                                    </div>

                                </div>

                            @empty

                                <div class="text-center py-10 text-slate-400">
                                    Belum ada pengumuman.
                                </div>

                            @endforelse

                        </div>

                    </div>

                    {{-- MASUK & PULANG --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- MASUK --}}
                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                                        Masuk
                                    </p>

                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                                        {{ $presensiHariIni ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i') : '--:--' }}
                                    </div>

                                    <div class="mt-1 text-xs font-bold {{ $presensiHariIni ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $presensiHariIni ? 'Tercatat' : 'Belum presensi' }}
                                    </div>

                                </div>

                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center ring-1 ring-emerald-600/10">

                                    <svg class="w-6 h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                    </svg>

                                </div>

                            </div>

                        </div>

                        {{-- PULANG --}}
                        <div class="bg-white rounded-2xl shadow-soft border border-slate-200 p-6">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                                        Pulang
                                    </p>

                                    <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                                        {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? \Carbon\Carbon::parse($presensiHariIni->jam_pulang)->format('H:i') : '--:--' }}
                                    </div>

                                    <div class="mt-1 text-xs font-bold {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'text-amber-600' : 'text-slate-400' }}">
                                        {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'Tercatat' : 'Belum presensi pulang' }}
                                    </div>

                                </div>

                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center ring-1 ring-amber-600/10">

                                    <svg class="w-6 h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                    </svg>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                        <div class="bg-white rounded-3xl p-6 shadow-soft border border-slate-100">

                            {{-- HEADER --}}
                            <div class="flex items-center justify-between mb-5">

                                <div>
                                    <h3 class="text-lg font-black text-slate-800">
                                        Kalender Akademik
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Jadwal kegiatan akademik.
                                    </p>
                                </div>

                                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                            </div>

                            {{-- CALENDAR --}}
                            <div class="rounded-2xl border border-slate-200 p-4">

                                {{-- MONTH --}}
                                <div class="flex items-center justify-between mb-4">

                                    <button class="text-slate-400 hover:text-slate-600">
                                        ←
                                    </button>

                                    <h4 class="font-bold text-slate-800">
                                        {{ now()->translatedFormat('F Y') }}
                                    </h4>

                                    <button class="text-slate-400 hover:text-slate-600">
                                        →
                                    </button>

                                </div>

                                <div
                                    x-data="calendarData()"
                                    x-init="init()"
                                >

                                    {{-- DAYS --}}
                                    <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-400 mb-3">

                                        <div>Min</div>
                                        <div>Sen</div>
                                        <div>Sel</div>
                                        <div>Rab</div>
                                        <div>Kam</div>
                                        <div>Jum</div>
                                        <div>Sab</div>

                                    </div>

                                    {{-- DATES --}}
                                    <div class="grid grid-cols-7 gap-2 text-sm">

                                        @for($i = 1; $i <= now()->daysInMonth; $i++)

                                            <button
                                                type="button"
                                                @click="selectDate({{ $i }})"

                                                class="
                                                    h-10 rounded-xl flex items-center justify-center
                                                    font-semibold transition relative

                                                    {{ $i == now()->day
                                                        ? 'bg-[#006fcf] text-white shadow-lg'
                                                        : 'text-slate-600 hover:bg-slate-100'
                                                    }}
                                                "
                                            >

                                                {{ $i }}

                                                {{-- DOT EVENT --}}
                                                <template x-if="hasEvent({{ $i }})">
                                                    <span class="absolute bottom-1 w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                </template>

                                            </button>

                                        @endfor

                                    </div>

                                    {{-- EVENT DETAIL --}}
                                    <div class="mt-5">

                                        <template x-if="selectedEvents.length > 0">

                                            <div class="space-y-3">

                                                <template x-for="event in selectedEvents" :key="event.id">

                                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">

                                                        <div class="flex items-start gap-3">

                                                            <div class="mt-1 w-2.5 h-2.5 rounded-full bg-orange-400"></div>

                                                            <div>

                                                                <p
                                                                    class="font-bold text-sm text-slate-800"
                                                                    x-text="event.judul"
                                                                ></p>

                                                                <p class="text-xs text-slate-500 mt-1">

                                                                    <span x-text="event.tanggal_mulai"></span>

                                                                </p>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </template>

                                            </div>

                                        </template>

                                        {{-- EMPTY --}}
                                        <template x-if="selected && selectedEvents.length === 0">

                                            <div class="text-center py-5 text-sm text-slate-400">

                                                Tidak ada agenda akademik pada tanggal ini.

                                            </div>

                                        </template>

                                    </div>

                                </div>

                                </div>

                                </div>

                            </div>

                        </div>

                                </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>

        function calendarData() {

            return {

                selected: null,

                selectedEvents: [],

                events: @json($kalenders),

                init() {

                    this.selectDate({{ now()->day }});

                },

                selectDate(day) {

                    this.selected = day;

                    const month = "{{ now()->format('m') }}";
                    const year = "{{ now()->format('Y') }}";

                    const clickedDate =
                        `${year}-${month}-${String(day).padStart(2, '0')}`;

                    this.selectedEvents = this.events.filter(event => {

                        return event.tanggal_mulai === clickedDate;

                    });

                },

                hasEvent(day) {

                    const month = "{{ now()->format('m') }}";
                    const year = "{{ now()->format('Y') }}";

                    const checkDate =
                        `${year}-${month}-${String(day).padStart(2, '0')}`;

                    return this.events.some(event =>
                        event.tanggal_mulai === checkDate
                    );

                }

            }

        }

    </script>

</x-app-layout>