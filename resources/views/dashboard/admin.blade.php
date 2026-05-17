```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

            <!-- LEFT -->
            <div>
                <p class="text-[#f4c542] text-xs font-black uppercase tracking-[0.35em]">
                    Sistem Presensi POLIBAN
                </p>

                <h2 class="mt-2 text-3xl xl:text-4xl font-black text-black leading-tight">
                    Dashboard Administrator
                </h2>

                <p class="mt-2 text-black/70 text-sm max-w-2xl">
                    Monitoring kehadiran tenaga kependidikan secara realtime
                    berbasis lokasi GPS dan dokumentasi selfie.
                </p>
            </div>

            <!-- RIGHT -->
            <div class="grid grid-cols-2 gap-4">

                <div class="bg-white/10 backdrop-blur rounded-2xl px-5 py-4 border border-white/10">
                    <p class="text-white/60 text-xs uppercase tracking-widest font-bold">
                        Hari Ini
                    </p>

                    <h3 class="text-white text-lg font-black mt-1">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </h3>
                </div>

                <div class="bg-[#f4c542] rounded-2xl px-5 py-4 shadow-xl">
                    <p class="text-[#0b3c70]/70 text-xs uppercase tracking-widest font-black">
                        Waktu
                    </p>

                    <h3 class="text-[#0b3c70] text-2xl font-black mt-1">
                        <span id="clock"></span>
                    </h3>
                </div>

            </div>
        </div>

        <!-- CLOCK -->
        <script>
            function updateClock() {
                const now = new Date();

                const time = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });

                document.getElementById('clock').innerHTML = time + ' WITA';
            }

            setInterval(updateClock, 1000);
            updateClock();
        </script>
    </x-slot>

    <div class="space-y-8">

        <!-- QUICK ACTION -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

            <a href="{{ route('admin.pegawai.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-lg border border-slate-100 hover:-translate-y-1 transition">

                <div class="w-14 h-14 rounded-2xl bg-[#0b3c70] text-white flex items-center justify-center shadow-lg">
                    👥
                </div>

                <h3 class="mt-5 text-lg font-black text-slate-800">
                    Data Pegawai
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola data tenaga kependidikan
                </p>

            </a>

            <a href="{{ route('admin.presensi.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-lg border border-slate-100 hover:-translate-y-1 transition">

                <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg">
                    🕒
                </div>

                <h3 class="mt-5 text-lg font-black text-slate-800">
                    Data Presensi
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Monitoring presensi harian
                </p>

            </a>

            <a href="{{ route('admin.jadwal-kerja.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-lg border border-slate-100 hover:-translate-y-1 transition">

                <div class="w-14 h-14 rounded-2xl bg-orange-500 text-white flex items-center justify-center shadow-lg">
                    📅
                </div>

                <h3 class="mt-5 text-lg font-black text-slate-800">
                    Jadwal Kerja
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Atur jadwal dan WFH Jumat
                </p>

            </a>

            <a href="{{ route('admin.users.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-lg border border-slate-100 hover:-translate-y-1 transition">

                <div class="w-14 h-14 rounded-2xl bg-[#f4c542] text-[#0b3c70] flex items-center justify-center shadow-lg">
                    ⚙️
                </div>

                <h3 class="mt-5 text-lg font-black text-slate-800">
                    Data Users
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Manajemen akun pengguna
                </p>

            </a>

        </div>

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

                <div class="px-4 py-2 rounded-2xl bg-[#0b3c70]/10 text-[#0b3c70] text-sm font-bold">
                    Realtime Data
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
                    data: [180, 192, 176, 201, 154, 0, 0]
                }],

                xaxis: {
                    categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']
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

        <!-- TABLE -->
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">

            <!-- HEADER -->
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>
                        <h3 class="text-2xl font-black text-[#0b3c70]">
                            Presensi Hari Ini
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Monitoring kehadiran tenaga kependidikan secara realtime.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 font-bold text-sm">
                        🟢 Sistem Aktif
                    </div>

                </div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-[#0b3c70] text-white">

                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-black uppercase tracking-widest">
                                Pegawai
                            </th>

                            <th class="px-6 py-5 text-left text-xs font-black uppercase tracking-widest">
                                Unit Kerja
                            </th>

                            <th class="px-6 py-5 text-left text-xs font-black uppercase tracking-widest">
                                Jam Masuk
                            </th>

                            <th class="px-6 py-5 text-left text-xs font-black uppercase tracking-widest">
                                Jam Pulang
                            </th>

                            <th class="px-6 py-5 text-left text-xs font-black uppercase tracking-widest">
                                Status
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($presensiHariIni as $presensi)

                            <tr class="hover:bg-slate-50 transition">

                                <!-- PEGAWAI -->
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="w-12 h-12 rounded-2xl bg-[#0b3c70] text-white flex items-center justify-center font-black">
                                            {{ strtoupper(substr($presensi->tenagaKependidikan->nama ?? 'P',0,1)) }}
                                        </div>

                                        <div>
                                            <div class="font-black text-slate-800">
                                                {{ $presensi->tenagaKependidikan->nama ?? '-' }}
                                            </div>

                                            <div class="text-xs text-slate-400 font-semibold">
                                                {{ $presensi->tenagaKependidikan->nip ?? '-' }}
                                            </div>
                                        </div>

                                    </div>

                                </td>

                                <!-- UNIT -->
                                <td class="px-6 py-5 text-sm font-semibold text-slate-600">
                                    {{ $presensi->tenagaKependidikan->unitKerja->nama_unit ?? '-' }}
                                </td>

                                <!-- MASUK -->
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-100 text-emerald-700 text-xs font-black">
                                        {{ $presensi->jam_masuk ?? '-' }}
                                    </span>
                                </td>

                                <!-- PULANG -->
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 text-xs font-black">
                                        {{ $presensi->jam_pulang ?? '-' }}
                                    </span>
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-5">

                                    @if($presensi->jam_pulang)

                                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 text-xs font-black">
                                            Presensi Lengkap
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-yellow-100 text-yellow-700 text-xs font-black">
                                            Belum Pulang
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="py-16 text-center">

                                    <div class="flex flex-col items-center justify-center">

                                        <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-4xl">
                                            📭
                                        </div>

                                        <h3 class="mt-5 text-xl font-black text-slate-700">
                                            Belum Ada Presensi
                                        </h3>

                                        <p class="mt-2 text-slate-400">
                                            Belum ada pegawai yang melakukan presensi hari ini.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</x-app-layout>
```
