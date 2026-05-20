<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Detail Presensi') }}
                </h2>

                <p class="mt-1 text-black-70 text-sm font-medium">
                    Informasi lengkap data presensi pegawai.
                </p>
            </div>

            <a href="{{ route('admin.presensi.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>

                Kembali
            </a>

        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">

            {{-- HEADER --}}
            <div class="p-8 border-b border-slate-100/70 dark:border-white/10">

                <div class="flex flex-col md:flex-row md:items-center gap-5">

                    <div class="w-20 h-20 rounded-3xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-3xl font-black text-indigo-700 dark:text-indigo-200 ring-1 ring-indigo-600/10">

                        {{ strtoupper(substr($presensi->user->tenagaKependidikan->nama ?? 'P', 0, 1)) }}

                    </div>

                    <div>

                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                            {{ $presensi->user->tenagaKependidikan->nama ?? '-' }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-500 font-mono">
                            NIP: {{ $presensi->user->tenagaKependidikan->nip ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- CONTENT --}}
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- TANGGAL --}}
                <div class="rounded-3xl border border-slate-100 dark:border-white/10 p-6 bg-slate-50/50 dark:bg-white/5">

                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400 font-black">
                        Tanggal
                    </p>

                    <h4 class="mt-3 text-xl font-black text-slate-800 dark:text-white">
                        {{ \Carbon\Carbon::parse($presensi->tanggal)->isoFormat('dddd, DD MMMM YYYY') }}
                    </h4>

                </div>

                {{-- JAM MASUK --}}
                <div class="rounded-3xl border border-emerald-100 dark:border-emerald-500/10 p-6 bg-emerald-50/50 dark:bg-emerald-500/5">

                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-500 font-black">
                        Jam Masuk
                    </p>

                    <h4 class="mt-3 text-2xl font-black text-emerald-700 dark:text-emerald-200">
                        {{ $presensi->jam_masuk ?? '--:--' }}
                    </h4>

                </div>

                {{-- JAM PULANG --}}
                <div class="rounded-3xl border border-amber-100 dark:border-amber-500/10 p-6 bg-amber-50/50 dark:bg-amber-500/5">

                    <p class="text-xs uppercase tracking-[0.2em] text-amber-500 font-black">
                        Jam Pulang
                    </p>

                    <h4 class="mt-3 text-2xl font-black text-amber-700 dark:text-amber-200">
                        {{ $presensi->jam_pulang ?? '--:--' }}
                    </h4>

                </div>

                {{-- STATUS --}}
                <div class="rounded-3xl border border-slate-100 dark:border-white/10 p-6 bg-slate-50/50 dark:bg-white/5">

                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400 font-black">
                        Status Presensi
                    </p>

                    <div class="mt-4">

                        @if($presensi->jam_pulang)

                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200 ring-1 ring-emerald-600/10">

                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>

                                Presensi Lengkap
                            </span>

                        @else

                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-200 ring-1 ring-amber-600/10">

                                <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span>

                                Belum Presensi Pulang
                            </span>

                        @endif

                    </div>

                </div>

            </div>

            {{-- FOTO --}}
            <div class="px-8 pb-8">

                <div class="rounded-3xl border border-slate-100 dark:border-white/10 p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h3 class="text-lg font-black text-slate-800 dark:text-white">
                                Foto Presensi
                            </h3>

                            <p class="text-sm text-slate-500">
                                Dokumentasi foto saat presensi.
                            </p>
                        </div>

                    </div>

                    @if($presensi->foto->count() > 0)

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                            @foreach($presensi->foto as $foto)

                                <div class="group relative overflow-hidden rounded-3xl border border-slate-100 dark:border-white/10 bg-slate-50 dark:bg-white/5">

                                    <img
                                        src="{{ asset('storage/presensi/' . $foto->foto) }}"
                                        class="w-full h-72 object-cover group-hover:scale-105 transition duration-300"
                                    >

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="py-16 text-center">

                            <svg class="w-16 h-16 text-slate-200 mx-auto mb-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                            </svg>

                            <p class="text-slate-400 font-medium">
                                Tidak ada foto presensi.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>