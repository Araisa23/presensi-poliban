<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                    Kalender Akademik & Libur Nasional
                </h3>
                <p class="text-slate-500 text-sm mt-1">Kelola agenda akademik dan hari libur nasional.</p>
            </div>
            <a href="{{ route('admin.kalender-akademik.create') }}"
                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] 
                text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 hover:scale-[1.02] transition min-w-[180px]">
                + Tambah Hari Libur/Agenda
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/70 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <!-- STATISTIC -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Total Agenda</p>
                        <h3 class="mt-2 text-4xl font-black text-slate-900">{{ $events->count() }}</h3>
                        <p class="mt-1 text-xs font-bold text-slate-500">Kalender Aktif</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#006fcf]">📅</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Hari Libur</p>
                        <h3 class="mt-2 text-4xl font-black text-slate-900">{{ $events->where('jenis', 'nasional')->count() }}</h3>
                        <p class="mt-1 text-xs font-bold text-slate-500">Libur Nasional</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">🏖️</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Tahun Aktif</p>
                        <h3 class="mt-2 text-4xl font-black text-slate-900">{{ now()->year }}</h3>
                        <p class="mt-1 text-xs font-bold text-slate-500">Kalender Aktif</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">📆</div>
                </div>
            </div>

        </div>

        <!-- CALENDAR -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>
                        <h3 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                            Kalender Akademik
                        </h3>
                        <p class="text-slate-500 text-sm mt-1">Agenda akademik dan hari libur nasional.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 text-sm">

                        {{-- LEGEND --}}
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#0b3c70]"></div>
                            <span class="text-slate-600 font-semibold">Agenda Akademik</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-slate-600 font-semibold">Libur Nasional</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-300"></div>
                            <span class="text-slate-600 font-semibold">Akhir Pekan</span>
                        </div>

                        {{-- DROPDOWN BULAN --}}
                        @php
                            $bulanList = [
                                1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                                5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                                9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
                            ];
                            $minYear = $events->min(fn($e) => \Carbon\Carbon::parse($e->tanggal_mulai)->year) ?? now()->year;
                            $maxYear = max($events->max(fn($e) => \Carbon\Carbon::parse($e->tanggal_mulai)->year) ?? now()->year, now()->year + 2);
                        @endphp

                        {{-- DROPDOWN BULAN - pakai x-ref agar bisa dibaca antar komponen --}}
                        <div x-data="{
                                 open: false,
                                 selectedIndex: {{ now()->month }},
                                 selectedLabel: '{{ $bulanList[now()->month] }}'
                             }"
                             x-ref="monthDrop"
                             id="monthDropdown"
                             class="relative">
                            <button @click="open = !open" type="button"
                                    class="flex items-center gap-2 px-4 py-2.5 bg-white
                                    border-2 border-slate-200 rounded-2xl shadow-sm
                                    text-sm font-bold text-slate-700
                                    hover:border-[#0b3c70] hover:shadow-md transition-all duration-200">
                                <span x-text="selectedLabel"></span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                     :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 x-cloak
                                 class="absolute right-0 mt-2 min-w-[140px] bg-white rounded-2xl
                                 shadow-xl border border-slate-200 overflow-hidden z-50">
                                @foreach($bulanList as $num => $nama)
                                    <button type="button"
                                            @click="
                                                selectedIndex = {{ $num }};
                                                selectedLabel = '{{ $nama }}';
                                                open = false;
                                                const yrData = Alpine.$data(document.getElementById('yearDropdown'));
                                                const yr = yrData ? yrData.selected : '{{ now()->year }}';
                                                window.calendar.gotoDate(yr + '-' + String({{ $num }}).padStart(2,'0') + '-01');
                                            "
                                            class="w-full text-left px-4 py-2.5 text-sm font-semibold
                                            text-slate-700 hover:bg-blue-50 hover:text-[#0b3c70] transition-colors"
                                            :class="selectedIndex === {{ $num }} ? 'bg-blue-50 text-[#0b3c70]' : ''">
                                        {{ $nama }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- DROPDOWN TAHUN --}}
                        <div x-data="{ open: false, selected: '{{ now()->year }}' }"
                             id="yearDropdown"
                             class="relative">
                            <button @click="open = !open" type="button"
                                    class="flex items-center gap-2 px-4 py-2.5 bg-white
                                    border-2 border-slate-200 rounded-2xl shadow-sm
                                    text-sm font-bold text-slate-700
                                    hover:border-[#0b3c70] hover:shadow-md transition-all duration-200">
                                <span x-text="selected"></span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                     :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 x-cloak
                                 class="absolute right-0 mt-2 min-w-[110px] bg-white rounded-2xl
                                 shadow-xl border border-slate-200 overflow-hidden z-50">
                                @for($year = min($minYear, now()->year - 2); $year <= $maxYear; $year++)
                                    <button type="button"
                                            @click="
                                                selected = '{{ $year }}';
                                                open = false;
                                                const moData = Alpine.$data(document.getElementById('monthDropdown'));
                                                const mm = moData ? String(moData.selectedIndex).padStart(2,'0') : '01';
                                                window.calendar.gotoDate('{{ $year }}-' + mm + '-01');
                                            "
                                            class="w-full text-left px-4 py-2.5 text-sm font-semibold
                                            text-slate-700 hover:bg-blue-50 hover:text-[#0b3c70] transition-colors"
                                            :class="selected === '{{ $year }}' ? 'bg-blue-50 text-[#0b3c70]' : ''">
                                        {{ $year }}
                                    </button>
                                @endfor
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="p-6">
                <div id="calendar"></div>
            </div>

        </div>

        <!-- EVENT TABLE -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                        Data Kalender
                    </h3>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1116.65 2a7.5 7.5 0 010 14.65z"/>
                            </svg>
                            <input type="text" id="searchInput" placeholder="Cari agenda..."
                                   class="pl-9 pr-4 py-2 rounded-xl border border-slate-300 bg-white
                                   text-sm font-medium text-slate-700 shadow-sm w-48
                                   focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] outline-none">
                        </div>
                        <select id="filterJenis"
                                class="px-4 py-2 rounded-xl border border-slate-300 bg-white
                                text-sm font-semibold text-slate-700 shadow-sm
                                focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70]">
                            <option value="semua">Semua Jenis</option>
                            <option value="akademik">Akademik</option>
                            <option value="nasional">Libur Nasional</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">Agenda / Hari Libur</th>
                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-center border-b border-slate-100">Jenis</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">Tanggal Mulai</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">Tanggal Selesai</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">Keterangan</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody" class="divide-y divide-slate-100">
                        @forelse($events as $event)
                            <tr class="hover:bg-slate-50 transition event-row"
                                data-judul="{{ strtolower($event->judul) }}"
                                data-jenis="{{ $event->jenis }}">

                                <td class="px-6 py-5">
                                    <div class="font-semibold text-slate-800">{{ $event->judul }}</div>
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @if($event->jenis == 'nasional')
                                        <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold">Libur Nasional</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">Akademik</span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600">
                                    @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-500">
                                    {{ $event->keterangan ?? '-' }}
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center gap-2">

                                        <a href="{{ route('admin.kalender-akademik.edit', $event->id) }}"
                                           class="inline-flex items-center justify-center px-4 py-2 rounded-2xl
                                           text-[11px] font-black uppercase tracking-[0.18em]
                                           bg-white text-slate-700 hover:bg-slate-50
                                           ring-1 ring-slate-200 shadow-sm transition">
                                            Edit
                                        </a>

                                        <div x-data="{ openDeleteModal: false }" class="inline-flex items-center">
                                            <button type="button" @click="openDeleteModal = true"
                                                    class="inline-flex items-center justify-center px-4 py-2 rounded-2xl
                                                    text-[11px] font-black uppercase tracking-[0.18em]
                                                    bg-rose-50 text-rose-700 hover:bg-rose-100
                                                    ring-1 ring-rose-200 transition">
                                                Hapus
                                            </button>

                                            <div x-show="openDeleteModal" x-transition
                                                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                                 style="display:none;">
                                                <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                                     @click="openDeleteModal = false"></div>
                                                <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">
                                                    <div class="p-8">
                                                        <div class="w-16 h-16 mx-auto rounded-3xl bg-rose-100 text-rose-600 flex items-center justify-center">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
                                                            </svg>
                                                        </div>
                                                        <div class="mt-6 text-center">
                                                            <h3 class="text-xl font-black text-slate-900">Hapus Kalender?</h3>
                                                            <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                                                                <span class="font-bold text-rose-600">{{ $event->judul }}</span>
                                                                akan dihapus permanen.
                                                            </p>
                                                        </div>
                                                        <div class="mt-8 flex items-center justify-center gap-3">
                                                            <button type="button" @click="openDeleteModal = false"
                                                                    class="px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition">
                                                                Batal
                                                            </button>
                                                            <form action="{{ route('admin.kalender-akademik.destroy', $event->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="px-5 py-2.5 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition">
                                                                    Ya, Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr id="emptyOriginal">
                                <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                    Belum ada data kalender.
                                </td>
                            </tr>
                        @endforelse

                        <tr id="emptyFilter" style="display:none;">
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                Tidak ada data yang sesuai dengan filter.
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <style>
    .fc { font-family: inherit; }

    /* ===== TOOLBAR ===== */
    .fc-toolbar { margin-bottom: 1.2rem !important; }
    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 900 !important;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .fc .fc-button-group { gap: 6px; }

    /* PREV / NEXT buttons */
    .fc-prev-button,
    .fc-next-button {
        background: white !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px !important;
        color: #334155 !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        padding: .45rem .75rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,.06) !important;
        transition: all .15s !important;
    }
    .fc-prev-button:hover,
    .fc-next-button:hover {
        background: #f8fafc !important;
        border-color: #0b3c70 !important;
        color: #0b3c70 !important;
        box-shadow: 0 2px 8px rgba(11,60,112,.12) !important;
    }
    .fc-prev-button:focus,
    .fc-next-button:focus { box-shadow: none !important; }

    /* TODAY button */
    .fc-today-button {
        background: white !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px !important;
        color: #0b3c70 !important;
        font-weight: 800 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: .1em !important;
        padding: .45rem .9rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,.06) !important;
        transition: all .15s !important;
    }
    .fc-today-button:hover {
        background: #eff6ff !important;
        border-color: #0b3c70 !important;
        box-shadow: 0 2px 8px rgba(11,60,112,.12) !important;
    }
    .fc-today-button:disabled {
        opacity: 0.4 !important;
        cursor: not-allowed !important;
    }
    .fc-today-button:focus { box-shadow: none !important; }

    /* ===== GRID ===== */
    .fc-day-today { background: rgba(11,60,112,.04) !important; }
    .fc-theme-standard td,
    .fc-theme-standard th,
    .fc-theme-standard .fc-scrollgrid { border-color: #e2e8f0 !important; }
    .fc-col-header-cell {
        background: #f8fafc;
        padding: .75rem 0;
    }
    .fc-col-header-cell-cushion {
        font-size: 11px !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: .12em !important;
        color: #94a3b8 !important;
        text-decoration: none !important;
    }
    .fc-daygrid-day-number {
        font-weight: 700;
        font-size: 13px;
        color: #334155;
        text-decoration: none !important;
        padding: 6px 8px !important;
    }
    .fc-daygrid-day-number:hover { color: #0b3c70; }

    /* ===== EVENTS ===== */
    .fc-event {
        border: none !important;
        border-radius: 8px !important;
        padding: 2px 8px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        cursor: pointer;
        letter-spacing: .01em;
    }
    .fc-event:hover { opacity: .88; }
    .fc-daygrid-day-frame { min-height: 70px !important; }
    .fc-daygrid-body-natural .fc-daygrid-day-events { margin-bottom: 2px !important; }
    .fc-header-toolbar { margin-bottom: 1rem !important; }

    /* ===== WEEKEND: Sabtu & Minggu ===== */
    .fc-col-header-cell.fc-day-sun .fc-col-header-cell-cushion,
    .fc-col-header-cell.fc-day-sat .fc-col-header-cell-cushion {
        color: #e11d48 !important;
    }
    .fc-day-sun .fc-daygrid-day-number,
    .fc-day-sat .fc-daygrid-day-number {
        color: #e11d48 !important;
    }
    .fc-day-sun:not(.fc-day-today),
    .fc-day-sat:not(.fc-day-today) {
        background-color: rgba(255, 241, 242, 0.5) !important;
    }
    .fc-day-today.fc-day-sun .fc-daygrid-day-number,
    .fc-day-today.fc-day-sat .fc-daygrid-day-number {
        color: #0b3c70 !important;
    }
    .fc-day-other .fc-daygrid-day-number { opacity: 0.28; }

    /* ===== TOOLTIP ===== */
    #fc-tooltip {
        position: fixed;
        z-index: 9999;
        background: #0f172a;
        color: white;
        padding: 10px 14px;
        border-radius: 14px;
        font-size: 12px;
        font-weight: 600;
        pointer-events: none;
        max-width: 230px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.22);
        display: none;
        line-height: 1.6;
    }
    </style>

    <div id="fc-tooltip"></div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const calendarEl = document.getElementById('calendar');
        const tooltip    = document.getElementById('fc-tooltip');

        @php
            $calendarEvents = $events->map(function($e) {
                return [
                    'id'    => $e->id,
                    'title' => $e->judul,
                    'start' => $e->tanggal_mulai,
                    'end'   => $e->tanggal_selesai
                                ? \Carbon\Carbon::parse($e->tanggal_selesai)->addDay()->format('Y-m-d')
                                : \Carbon\Carbon::parse($e->tanggal_mulai)->addDay()->format('Y-m-d'),
                    'color' => $e->jenis === 'nasional' ? '#ef4444' : '#0b3c70',
                    'extendedProps' => [
                        'jenis'           => $e->jenis,
                        'keterangan'      => $e->keterangan ?? '-',
                        'tanggal_mulai'   => \Carbon\Carbon::parse($e->tanggal_mulai)->translatedFormat('d F Y'),
                        'tanggal_selesai' => $e->tanggal_selesai
                                            ? \Carbon\Carbon::parse($e->tanggal_selesai)->translatedFormat('d F Y')
                                            : null,
                    ],
                ];
            })->values()->toArray();
        @endphp

        const events = {!! json_encode($calendarEvents) !!};

        const bulanLabel = [
            '','Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];

        window.calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            contentHeight: 450,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            buttonText: { today: 'Hari Ini' },
            events: events,

            // Sync kedua dropdown saat navigasi prev/next/today
            // Alpine v3: gunakan Alpine.$data(el) bukan el.__x.$data
            datesSet: function(dateInfo) {
                const center = new Date((dateInfo.start.getTime() + dateInfo.end.getTime()) / 2);
                const yr     = String(center.getFullYear());
                const mo     = center.getMonth() + 1;

                const yearEl  = document.getElementById('yearDropdown');
                const monthEl = document.getElementById('monthDropdown');

                if (yearEl) {
                    try { Alpine.$data(yearEl).selected = yr; } catch(e) {}
                }
                if (monthEl) {
                    try {
                        Alpine.$data(monthEl).selectedIndex = mo;
                        Alpine.$data(monthEl).selectedLabel = bulanLabel[mo];
                    } catch(e) {}
                }
            },

            // Tooltip hover
            eventMouseEnter: function(info) {
                const props = info.event.extendedProps;
                const jenis = props.jenis === 'nasional' ? '🏖️ Libur Nasional' : '📅 Akademik';
                let html = `<div style="font-size:13px;font-weight:800;margin-bottom:4px">${info.event.title}</div>`;
                html += `<div style="opacity:.8;margin-bottom:2px">${jenis}</div>`;
                html += `<div style="opacity:.7">${props.tanggal_mulai}`;
                if (props.tanggal_selesai && props.tanggal_selesai !== props.tanggal_mulai) {
                    html += ` → ${props.tanggal_selesai}`;
                }
                html += '</div>';
                if (props.keterangan && props.keterangan !== '-') {
                    html += `<div style="opacity:.6;margin-top:4px;font-size:11px">${props.keterangan}</div>`;
                }
                tooltip.innerHTML = html;
                tooltip.style.display = 'block';
            },
            eventMouseLeave: function() {
                tooltip.style.display = 'none';
            },
            eventDidMount: function(info) {
                info.el.addEventListener('mousemove', function(e) {
                    tooltip.style.left = (e.clientX + 12) + 'px';
                    tooltip.style.top  = (e.clientY + 12) + 'px';
                });
            },
        });

        window.calendar.render();

        // Search + Filter tabel
        const searchInput = document.getElementById('searchInput');
        const filterJenis = document.getElementById('filterJenis');
        const rows        = document.querySelectorAll('.event-row');
        const emptyFilter = document.getElementById('emptyFilter');

        function applyFilter() {
            const keyword = searchInput.value.toLowerCase().trim();
            const jenis   = filterJenis.value;
            let visible   = 0;

            rows.forEach(function(row) {
                const match = row.dataset.judul.includes(keyword) &&
                              (jenis === 'semua' || row.dataset.jenis === jenis);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            emptyFilter.style.display = visible === 0 ? '' : 'none';
        }

        if (searchInput) searchInput.addEventListener('input', applyFilter);
        if (filterJenis) filterJenis.addEventListener('change', applyFilter);

    });
    </script>
</x-app-layout>