<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <!-- LEFT -->
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    Kalender Akademik
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
                    Kelola agenda akademik dan hari penting kampus.
                </p>
            </div>

            <!-- BUTTON -->
            <a href="{{ route('admin.kalender-akademik.create') }}"
               class="inline-flex items-center justify-center px-6 py-4
               rounded-2xl font-black text-xs uppercase tracking-[0.2em]
               bg-gradient-to-b from-indigo-600 to-indigo-700
               text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)]
               ring-1 ring-indigo-600/20 transition text-center min-w-[180px]">

                + Tambah Event

            </a>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- ALERT -->
        @if(session('success'))

            <div class="p-4 rounded-2xl
                        bg-emerald-50/70 dark:bg-emerald-500/10
                        border border-emerald-200/70
                        dark:border-emerald-500/20
                        text-emerald-800 dark:text-emerald-200
                        shadow-soft">

                {{ session('success') }}

            </div>

        @endif

        <!-- STATISTIC -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- TOTAL -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6
                        border border-slate-100/70 dark:border-white/10 shadow-soft">

                <p class="text-xs font-black uppercase tracking-[0.25em] text-slate-400">
                    Total Event
                </p>

                <h3 class="mt-3 text-5xl font-black text-[#0b3c70] dark:text-white">
                    {{ $events->count() }}
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Event akademik tersimpan
                </p>

            </div>

            <!-- LIBUR -->
            <div class="bg-gradient-to-br from-red-500 to-red-600
                        rounded-3xl p-6 text-white shadow-soft">

                <p class="text-xs font-black uppercase tracking-[0.25em] text-red-100">
                    Hari Libur
                </p>

                <h3 class="mt-3 text-5xl font-black">
                    {{ \App\Models\HariLibur::count() }}
                </h3>

                <p class="mt-2 text-sm text-red-100">
                    Hari libur nasional
                </p>

            </div>

            <!-- YEAR -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600
                        rounded-3xl p-6 text-white shadow-soft">

                <p class="text-xs font-black uppercase tracking-[0.25em] text-emerald-100">
                    Tahun Aktif
                </p>

                <h3 class="mt-3 text-5xl font-black">
                    {{ now()->year }}
                </h3>

                <p class="mt-2 text-sm text-emerald-100">
                    Kalender akademik aktif
                </p>

            </div>

        </div>

        <!-- CALENDAR -->
        <div class="bg-white dark:bg-slate-900 overflow-hidden
                    shadow-soft rounded-3xl
                    border border-slate-100/70 dark:border-white/10">

            <div class="px-6 py-5 border-b border-slate-100/70 dark:border-white/10">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>

                        <h3 class="text-xl font-black text-slate-800 dark:text-white">
                            Kalender Event
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Agenda akademik & hari penting kampus
                        </p>

                    </div>

                    <div class="flex items-center gap-4 text-sm">

                        <div class="flex items-center gap-2">

                            <div class="w-3 h-3 rounded-full bg-[#0b3c70]"></div>

                            <span class="text-slate-600 dark:text-slate-300 font-semibold">
                                Event Akademik
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
        <div class="bg-white dark:bg-slate-900 overflow-hidden
                    shadow-soft rounded-3xl
                    border border-slate-100/70 dark:border-white/10">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <!-- HEAD -->
                    <thead>

                        <tr class="bg-slate-50/70 dark:bg-white/5">

                            <th class="px-6 py-5 text-[10px] font-black
                                       text-slate-400 uppercase tracking-[0.25em]
                                       border-b border-slate-100/70 dark:border-white/10">

                                Event

                            </th>

                            <th class="px-6 py-5 text-[10px] font-black
                                       text-slate-400 uppercase tracking-[0.25em]
                                       border-b border-slate-100/70 dark:border-white/10">

                                Tanggal

                            </th>

                            <th class="px-6 py-5 text-[10px] font-black
                                       text-slate-400 uppercase tracking-[0.25em]
                                       border-b border-slate-100/70 dark:border-white/10">

                                Keterangan

                            </th>

                            <th class="px-6 py-5 text-right text-[10px] font-black
                                       text-slate-400 uppercase tracking-[0.25em]
                                       border-b border-slate-100/70 dark:border-white/10">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">

                        @forelse($events as $event)

                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">

                                <!-- EVENT -->
                                <td class="px-6 py-5">

                                    <div class="font-black text-slate-800 dark:text-white">
                                        {{ $event->judul }}
                                    </div>

                                </td>

                                <!-- DATE -->
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-300">

                                    {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}

                                </td>

                                <!-- DESC -->
                                <td class="px-6 py-5 text-sm text-slate-500">

                                    {{ $event->keterangan }}

                                </td>

                                <!-- ACTION -->
                                <td class="px-6 py-5 text-right">

                                    <div class="inline-flex items-center gap-2">

                                        <!-- EDIT -->
                                        <a href="{{ route('admin.kalender-akademik.edit', $event->id) }}"
                                           class="inline-flex items-center justify-center
                                           px-4 py-2 rounded-2xl text-[11px]
                                           font-black uppercase tracking-[0.18em]
                                           bg-white/80 dark:bg-white/10
                                           text-slate-700 dark:text-slate-100
                                           hover:bg-white dark:hover:bg-white/15
                                           ring-1 ring-slate-900/10
                                           dark:ring-white/10 shadow-soft transition">

                                            Edit

                                        </a>

                                        <!-- DELETE -->
                                        <form action="{{ route('admin.kalender-akademik.destroy', $event->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus event ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center justify-center
                                                    px-4 py-2 rounded-2xl text-[11px]
                                                    font-black uppercase tracking-[0.18em]
                                                    bg-rose-50/80 dark:bg-rose-500/10
                                                    text-rose-700 dark:text-rose-200
                                                    hover:bg-rose-100/70
                                                    dark:hover:bg-rose-500/15
                                                    ring-1 ring-rose-600/10
                                                    dark:ring-rose-500/20 transition">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="px-6 py-12 text-center
                                           text-slate-400 font-medium italic">

                                    Belum ada event kalender akademik.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- FULLCALENDAR -->
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
                        start: '{{ $event->tanggal }}',
                        color: '#0b3c70'
                    },

                    @endforeach

                    @foreach(\App\Models\HariLibur::all() as $libur)

                    {
                        title: '{{ $libur->keterangan }}',
                        start: '{{ $libur->tanggal }}',
                        color: '#ef4444'
                    },

                    @endforeach

                ]

            });

            calendar.render();

        });

    </script>

</x-app-layout>