<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#004b8d] to-[#006fcf] text-white flex items-center justify-center shadow-sm shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6M3 7h18M3 12h18"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                        Detail Presensi
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Informasi lengkap data presensi pegawai
                    </p>
                </div>
            </div>

            <x-back-button href="{{ route('pimpinan.monitoring') }}">
                Kembali
            </x-back-button>

        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- ===== CARD IDENTITAS ===== --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Header card dengan gradient --}}
            <div class="bg-gradient-to-r from-[#004b8d] to-[#006fcf] px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                    {{-- Avatar inisial --}}
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm ring-2 ring-white/30 flex items-center justify-center text-2xl font-black text-white shrink-0">
                        {{ strtoupper(substr($presensi->user->tenagaKependidikan->nama ?? 'P', 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="text-xl font-black text-white">
                            {{ $presensi->user->tenagaKependidikan->nama ?? '-' }}
                        </h3>
                        <p class="mt-1 text-sm text-white text-slate-800 dark:text-slate-300">
                            NIP : {{ $presensi->user->tenagaKependidikan->nip ?? '-' }}
                        </p>

                        {{-- Badge status --}}
                        <div class="mt-3">
                            @if($presensi->jam_pulang)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-400/20 text-emerald-100 ring-1 ring-emerald-300/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
                                    Presensi Lengkap
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-400/20 text-amber-100 ring-1 ring-amber-300/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-300"></span>
                                    Belum Presensi Pulang
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            {{-- Grid info presensi --}}
            <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">

                {{-- Tanggal --}}
                <div class="sm:col-span-1 rounded-2xl border border-slate-100 bg-slate-50/60 p-5">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black mb-2 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Tanggal
                    </p>
                    <p class="text-base font-black text-slate-800 leading-snug">
                        {{ \Carbon\Carbon::parse($presensi->tanggal)->isoFormat('dddd,') }}
                    </p>
                    <p class="text-sm font-semibold text-slate-600">
                        {{ \Carbon\Carbon::parse($presensi->tanggal)->isoFormat('DD MMMM YYYY') }}
                    </p>
                </div>

                {{-- Jam Masuk --}}
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-emerald-500 font-black mb-2 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                        </svg>
                        Jam Masuk
                    </p>
                    <p class="text-3xl font-black text-emerald-700 tabular-nums">
                        {{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') : '--:--' }}
                    </p>
                    <p class="text-xs text-emerald-500 mt-1 font-semibold">
                        {{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('s') . ' detik' : 'Belum tercatat' }}
                    </p>
                </div>

                {{-- Jam Pulang --}}
                <div class="rounded-2xl border border-amber-100 bg-amber-50/60 p-5">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-amber-500 font-black mb-2 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                        Jam Pulang
                    </p>
                    <p class="text-3xl font-black text-amber-700 tabular-nums">
                        {{ $presensi->jam_pulang ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') : '--:--' }}
                    </p>
                    <p class="text-xs text-amber-500 mt-1 font-semibold">
                        {{ $presensi->jam_pulang ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('s') . ' detik' : 'Belum tercatat' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- ===== CARD FOTO ===== --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#004b8d]/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#004b8d]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800">Foto Presensi</h3>
                        <p class="text-xs text-slate-400">Dokumentasi foto saat presensi</p>
                    </div>
                </div>

                @if($presensi->foto->count() > 0)
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        {{ $presensi->foto->count() }} foto
                    </span>
                @endif
            </div>

            <div class="p-6">

                @if($presensi->foto->count() > 0)

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($presensi->foto as $index => $foto)
                            <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">

                                <img
                                    src="{{ asset('storage/presensi/' . $foto->foto) }}"
                                    alt="Foto Presensi {{ $index + 1 }}"
                                    class="w-full h-72 object-cover group-hover:scale-105 transition duration-500"
                                >

                                {{-- Label overlay --}}
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent px-4 py-3">
                                    <p class="text-xs font-bold text-white">
                                        Foto {{ $index + 1 }}
                                        @if($index === 0) · Masuk @else · Pulang @endif
                                    </p>
                                </div>

                            </div>
                        @endforeach
                    </div>

                @else

                    <div class="py-16 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-400">Tidak ada foto presensi</p>
                        <p class="text-xs text-slate-300 mt-1">Pegawai tidak mengambil foto saat presensi</p>
                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
