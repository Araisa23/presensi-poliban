<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <!-- LEFT -->
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    Kalender Libur Nasional & Akademik
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
                    Kelola hari libur nasional dan agenda akademik kampus dengan mudah.
                </p>
            </div>

            <!-- BUTTON -->
            <a href="{{ route('admin.kalender-akademik.create') }}"
               class="inline-flex items-center justify-center px-6 py-4
               rounded-2xl font-black text-xs uppercase tracking-[0.2em]
               bg-gradient-to-r from-[#004b8d] to-[#006fcf]
               text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)]
               ring-1 ring-[#0b3c70]/20 transition text-center min-w-[180px]">
                + Tambah Hari Libur
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">

        <!-- ALERT -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-500/10 border border-emerald-200/70 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200 shadow-soft">
                {{ session('success') }}
            </div>
        @endif

        <!-- STATISTIC -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- TOTAL AGENDA AKADEMIK --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-100/70 dark:border-white/10 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Total Agenda
                        </p>
                        <h3 class="mt-3 text-4xl font-black text-slate-800 dark:text-white">
                            {{ $events->count() }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Agenda akademik
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-[#0b3c70]/10 dark:bg-[#0b3c70]/100/10 flex items-center justify-center text-[#006fcf] dark:text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- LIBUR --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-100/70 dark:border-white/10 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Hari Libur
                        </p>
                        <h3 class="mt-3 text-4xl font-black text-slate-800 dark:text-white">
                            {{ $events->where('jenis', 'nasional')->count() }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Libur nasional tersimpan
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 118 0v2m-4-6v6" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- TAHUN --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-100/70 dark:border-white/10 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Tahun Aktif
                        </p>
                        <h3 class="mt-3 text-4xl font-black text-slate-800 dark:text-white">
                            {{ now()->year }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Kalender aktif
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- CALENDAR -->
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
            <div class="px-6 py-5 border-b border-slate-100/70 dark:border-white/10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-black text-slate-800 dark:text-white">
                            Kalender Akademik & Hari Libur Nasional
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Lihat agenda akademik dan hari libur nasional dalam satu tampilan kalender.
                        </p>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#0b3c70]"></div>
                            <span class="text-slate-600 dark:text-slate-300 font-semibold">
                                Agenda Akademik
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-slate-600 dark:text-slate-300 font-semibold">
                                Hari Libur
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div id="calendar"></div>
            </div>
        </div>

        <!-- EVENT TABLE -->
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Agenda / Hari Libur
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Tanggal
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Keterangan
                            </th>
                            <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                        @forelse($events as $event)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                <td class="px-6 py-5">
                                    <div class="font-black text-slate-800 dark:text-white">
                                        {{ $event->judul }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-500">
                                    {{ $event->keterangan }}
                                </td>
                                <td class="px-8 py-5 text-right">

                                    <div class="flex items-center justify-end gap-3"
                                        x-data="{ openDeleteModal: false }">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.kalender-akademik.edit', $event->id) }}"
                                        class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.15em] text-[#0b3c70] dark:text-blue-200 bg-blue-50/80 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 transition ring-1 ring-blue-600/10">

                                            Edit
                                        </a>

                                        {{-- DELETE --}}
                                        <button
                                            type="button"
                                            @click="openDeleteModal = true"
                                            class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.15em] text-rose-700 dark:text-rose-200 bg-rose-50/80 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 transition ring-1 ring-rose-600/10">

                                            Hapus
                                        </button>

                                        {{-- MODAL --}}
                                        <div
                                            x-show="openDeleteModal"
                                            x-transition
                                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                            style="display: none;"
                                        >

                                            {{-- OVERLAY --}}
                                            <div
                                                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                                @click="openDeleteModal = false"
                                            ></div>

                                            {{-- MODAL --}}
                                            <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden">

                                                <div class="p-8">

                                                    <div class="w-16 h-16 mx-auto rounded-3xl bg-rose-100 dark:bg-rose-500/10 text-rose-600 dark:text-rose-300 flex items-center justify-center">

                                                        <svg class="w-8 h-8"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24">

                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
                                                        </svg>

                                                    </div>

                                                    <div class="mt-6 text-center">

                                                        <h3 class="text-xl font-black text-slate-900 dark:text-white">
                                                            Hapus Kalender?
                                                        </h3>

                                                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                                            Kalender
                                                            <span class="font-bold text-rose-600">
                                                                {{ $event->judul }}
                                                            </span>
                                                            akan dihapus permanen.
                                                        </p>

                                                    </div>

                                                    <div class="mt-8 flex items-center justify-center gap-3">

                                                        {{-- CANCEL --}}
                                                        <button
                                                            type="button"
                                                            @click="openDeleteModal = false"
                                                            class="px-5 py-2.5 rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-100 dark:hover:bg-slate-700 transition">

                                                            Batal
                                                        </button>

                                                        {{-- DELETE --}}
                                                        <form action="{{ route('admin.kalender-akademik.destroy', $event->id) }}"
                                                            method="POST">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="px-5 py-2.5 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition">

                                                                Ya, Hapus
                                                            </button>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic">
                                    Belum ada agenda atau hari libur akademik.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FULLCALENDAR SCRIPTS AND STYLES -->
    <style>
        .fc { font-family: inherit; }
        .fc-toolbar-title { font-size: 1.2rem !important; font-weight: 900 !important; color: #0f172a; }
        .dark .fc-toolbar-title { color: white; }
        .fc-button {
            background: #006fcf !important;
            border: none !important;
            border-radius: 16px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 11px !important;
            letter-spacing: .08em;
            padding: .7rem 1rem !important;
            box-shadow: 0 10px 20px rgba(11,60,112,.25);}
        .fc-button:hover {background: #1D4ED8 !important;}
        .fc-theme-standard td, .fc-theme-standard th, .fc-theme-standard .fc-scrollgrid { border-color: rgb(241 245 249) !important; }
        .dark .fc-theme-standard td, .dark .fc-theme-standard th, .dark .fc-theme-standard .fc-scrollgrid { border-color: rgba(255,255,255,.08) !important; }
        .fc-daygrid-day-number { font-weight: 700; color: #334155; }
        .dark .fc-daygrid-day-number { color: white; }
        .fc-col-header-cell { background: rgb(248 250 252); padding: .8rem 0; }
        .dark .fc-col-header-cell { background: rgba(255,255,255,.03); }
        .fc-event { border: none !important; border-radius: 10px !important; padding: 2px 6px !important; font-size: 11px !important; font-weight: 700 !important; }
    </style>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 700,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: [
                @foreach($events as $event)
                {
                    title: '{{ $event->judul }}',
                    start: '{{ $event->tanggal_mulai }}',
                    end: '{{ \Carbon\Carbon::parse($event->tanggal_selesai)->addDay()->format("Y-m-d") }}',

                    color: '{{ $event->jenis == "nasional" ? "#ef4444" : "#0b3c70" }}'
                },
                @endforeach

                ]
            });
            calendar.render();
        });
    </script>
</x-app-layout>