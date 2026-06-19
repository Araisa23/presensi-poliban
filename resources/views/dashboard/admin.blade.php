<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            {{-- LEFT --}}
            <div>
                <p class="text-[#006fcf] text-[10px] font-black uppercase tracking-[0.3em] mb-2">
                    Halo {{ Auth::user()->name }}!
                </p>

                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight mb-1 text-slate-900">
                    {{ __('Selamat Datang di Dashboard') }}
                </h2>
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

    <div class="space-y-8">

        <!-- STATISTIC -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-4">

            <!-- TOTAL PEGAWAI -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Total Pegawai
                        </p>

                        <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                            {{ $totalPegawai }}
                        </div>

                        <div class="mt-1 text-xs font-bold text-slate-500">
                            Terdaftar
                        </div>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                        👥
                    </div>
                </div>
            </div>

            <!-- UNIT -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Unit Kerja
                        </p>

                        <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                            {{ $totalUnit }}
                        </div>

                        <div class="mt-1 text-xs font-bold text-slate-500">
                            Unit Aktif
                        </div>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                        🏢
                    </div>
                </div>
            </div>

            <!-- HADIR -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-emerald-600">
                            Hadir Hari Ini
                        </p>

                        <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                            {{ $hadirHariIni }}
                        </div>

                        <div class="mt-1 text-xs font-bold text-emerald-600">
                            Sudah Presensi
                        </div>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        ✅
                    </div>
                </div>
            </div>

            <!-- ALFA -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-rose-600">
                            Belum Presensi
                        </p>

                        <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">
                            {{ $totalAlfa }}
                        </div>

                        <div class="mt-1 text-xs font-bold text-rose-600">
                            Belum Tercatat
                        </div>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center">
                        ⚠️
                    </div>
                </div>
            </div>

        </div>

        <!-- GRAFIK -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between mb-4">

                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight mb-1 text-slate-900">
                        Grafik Kehadiran Mingguan
                    </h3>

                    <p class="text-slate-500 text-sm mt-1">
                        Statistik presensi tenaga kependidikan minggu ini.
                    </p>

            </div>

            <div id="attendanceChart"></div>

        </div>

        <script>

            var options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },

                series: [{
                    name: 'Jumlah Hadir',
                    data: @json($grafikKehadiran)
                }],

                xaxis: {
                    categories: @json($labelHari)
                },

                stroke: {
                    curve: 'smooth',
                    width: 4
                },

                dataLabels: {
                    enabled: false
                },

                colors: ['#0B3C70'],

                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.08,
                    }
                },

                grid: {
                    borderColor: '#e5e7eb'
                },

                tooltip: {
                    theme: 'light'
                },

                markers: {
                    size: 6
                }
            };

            var chart = new ApexCharts(
                document.querySelector("#attendanceChart"),
                options
            );

            chart.render();

        </script>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h3 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight mb-1 text-slate-900">
                    Data Presensi Hari Ini
                </h3>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">
                        <tr>

                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-left">
                                Pegawai
                            </th>

                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-center">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-center">
                                Jam Masuk
                            </th>

                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-center">
                                Jam Pulang
                            </th>

                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-center">
                                Foto
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($presensiHariIni as $p)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- PEGAWAI --}}
                                <td class="px-6 py-4">

                                    <div class="font-black text-slate-800">
                                        {{ $p->tenagaKependidikan->nama ?? '-' }}
                                    </div>

                                    <div class="text-xs text-slate-400">
                                        {{ $p->tenagaKependidikan->nip ?? '-' }}
                                    </div>

                                </td>

                                {{-- TANGGAL --}}
                                <td class="px-6 py-4 text-center text-slate-700 font-semibold">
                                    {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                                </td>

                                {{-- MASUK --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-black">
                                        {{ $p->jam_masuk ?? '--:--' }}
                                    </span>

                                </td>

                                {{-- PULANG --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-black">
                                        {{ $p->jam_pulang ?? '--:--' }}
                                    </span>

                                </td>

                                {{-- FOTO --}}
                                <td class="px-6 py-4 text-center">

                                    @if($p->foto && $p->foto->count() > 0)

                                        <div class="flex justify-center -space-x-2">

                                            @foreach($p->foto as $f)

                                                <img
                                                    src="{{ asset('storage/presensi/' . $f->foto) }}"
                                                    class="w-10 h-10 rounded-full object-cover border-2 border-white shadow"
                                                >

                                            @endforeach

                                        </div>

                                    @else

                                        <span class="text-xs text-slate-400">
                                            No Photo
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-12 text-slate-400 font-medium">

                                    Belum ada data presensi hari ini

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    <script>
    function updateClock() {

        const now = new Date();

        const time = now.toLocaleTimeString('id-ID', {
            hour12: false
        });

        const date = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById('clock').textContent = time;
        document.getElementById('date-now').textContent = date;
    }

    updateClock();
    setInterval(updateClock, 1000);
    </script>
</x-app-layout>