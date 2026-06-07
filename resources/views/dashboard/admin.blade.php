<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

            {{-- LEFT --}}
            <div>
                <p class="text-[#006fcf] text-[10px] font-black uppercase tracking-[0.3em] mb-1">
                    Halo, {{ Auth::user()->name }}
                </p>

                <h2 class="text-3xl xl:text-4xl font-black tracking-tight leading-tight">
                    Selamat datang di Dashboard Admin
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
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <!-- TOTAL PEGAWAI -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-slate-100">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-black">
                            Total Pegawai
                        </p>

                        <h3 class="mt-3 text-5xl font-black text-[#0b3c70]">
                            {{ $totalPegawai }}
                        </h3>

                        <p class="mt-2 text-sm text-slate-500 font-semibold">
                            Tenaga Kependidikan
                        </p>
                    </div>

                    <div class="w-16 h-16 rounded-3xl bg-[#0b3c70]/10 flex items-center justify-center text-3xl">
                        👨‍💼
                    </div>

                </div>
            </div>

            <!-- UNIT -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-slate-100">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-black">
                            Unit Kerja
                        </p>

                        <h3 class="mt-3 text-5xl font-black text-blue-600">
                            {{ $totalUnit }}
                        </h3>

                        <p class="mt-2 text-sm text-slate-500 font-semibold">
                            Unit Aktif
                        </p>
                    </div>

                    <div class="w-16 h-16 rounded-3xl bg-blue-100 flex items-center justify-center text-3xl">
                        🏢
                    </div>

                </div>
            </div>

            <!-- HADIR -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-slate-100">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-black">
                            Hadir Hari Ini
                        </p>

                        <h3 class="mt-3 text-5xl font-black text-emerald-600">
                            {{ $hadirHariIni }}
                        </h3>

                        <div class="mt-3 w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full"
                                style="width: {{ ($hadirHariIni / max($totalPegawai,1)) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="w-16 h-16 rounded-3xl bg-emerald-100 flex items-center justify-center text-3xl">
                        ✅
                    </div>

                </div>
            </div>

            <!-- ALFA -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-3xl p-6 shadow-lg text-white">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-red-100 font-black">
                            Belum Presensi
                        </p>

                        <h3 class="mt-3 text-5xl font-black">
                            {{ $totalAlfa }}
                        </h3>

                        <p class="mt-2 text-sm text-red-100 font-semibold">
                            Pegawai belum hadir
                        </p>
                    </div>

                    <div class="w-16 h-16 rounded-3xl bg-white/10 flex items-center justify-center text-3xl">
                        ❌
                    </div>

                </div>
            </div>

        </div>

        <!-- GRAFIK -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8">

            <div class="flex items-center justify-between mb-8">

                <div>
                    <h3 class="text-2xl font-black text-[#0b3c70]">
                        Grafik Kehadiran Mingguan
                    </h3>

                    <p class="text-slate-500 text-sm mt-1">
                        Statistik presensi tenaga kependidikan minggu ini.
                    </p>
                </div>

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
        <div class="bg-white rounded-3xl border border-slate-200 shadow-soft overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h3 class="text-lg font-black text-slate-800">
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
                                Masuk
                            </th>

                            <th class="px-6 py-4 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black text-center">
                                Pulang
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