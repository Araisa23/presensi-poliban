<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            {{-- LEFT --}}
            <div>
                <p class="text-[#006fcf] text-[10px] font-black uppercase tracking-[0.3em] mb-1">
                    Halo {{ Auth::user()->name }}!
                </p>

                <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                    Dashboard Monitoring Presensi
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Monitoring kehadiran pegawai secara realtime.
                </p>
            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-2">

                <div class="bg-white rounded-2xl px-5 py-2 shadow-sm border border-slate-200">

                    <div class="mt-1 text-sm font-bold text-slate-800">
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

    <div class="py-15">

        {{-- CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Total Pegawai</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $totalPegawai }}</div>
                            <div class="mt-1 text-xs font-bold text-slate-500">Terdaftar</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center">👥</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-emerald-600">Hadir Hari Ini</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $hadirHariIni }}</div>
                            <div class="mt-1 text-xs font-bold text-emerald-600">Tercatat masuk</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">✅</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-rose-600">Belum Hadir</p>
                            <div class="mt-2 text-4xl font-black tabular-nums text-slate-900">{{ $tidakHadir }}</div>
                            <div class="mt-1 text-xs font-bold text-rose-600">Belum tercatat</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center">⚠️</div>
                    </div>
                </div>
            </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- GRAFIK KEHADIRAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">
                    Tren Kehadiran Mingguan
                </h3>

                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                    Realtime
                </span>
            </div>

            <div id="attendanceChart"></div>

        </div>

        {{-- STATUS KEHADIRAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">
                Status Kehadiran
            </h3>

            <div id="statusChart"></div>

            <div class="mt-6 space-y-3">

                <div class="flex justify-between text-sm font-bold">
                    <span class="text-emerald-600">Hadir</span>
                    <span>{{ $hadirHariIni }}</span>
                </div>

                <div class="flex justify-between text-sm font-bold">
                    <span class="text-rose-600">Belum Hadir</span>
                    <span>{{ $tidakHadir }}</span>
                </div>

            </div>

        </div>

    </div>
        </div>

    <script>

        // AREA CHART
        var attendanceOptions = {

            chart: {
                type: 'area',
                height: 300,
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
                width: 3
            },

            dataLabels: {
                enabled: false
            },

            colors: ['#006fcf'],

            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.35,
                    opacityTo: 0.05
                }
            },

            grid: {
                borderColor: '#e5e7eb'
            }

        };

        new ApexCharts(
            document.querySelector("#attendanceChart"),
            attendanceOptions
        ).render();


        // DONUT CHART
        var statusOptions = {

            chart: {
                type: 'donut',
                height: 280
            },

            series: [
                {{ $hadirHariIni }},
                {{ $tidakHadir }}
            ],

            labels: [
                'Hadir',
                'Belum Hadir'
            ],

            colors: [
                '#10b981',
                '#f43f5e'
            ],

            legend: {
                position: 'bottom'
            }

        };

        new ApexCharts(
            document.querySelector("#statusChart"),
            statusOptions
        ).render();

    function updateClock() {
        const now = new Date();

        const time = now.toLocaleTimeString('id-ID', {
            hour12: false
        });

        document.getElementById('clock').textContent = time;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
</x-app-layout>