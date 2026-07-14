<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Log Percobaan Device Ditolak') }}
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Riwayat percobaan presensi dari perangkat yang tidak terdaftar.
                </p>
            </div>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-500/10 border border-emerald-200/70 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200 shadow-soft flex items-center">
                <svg class="w-5 h-5 mr-3"
                    fill="currentColor"
                    viewBox="0 0 20 20">

                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"/>
                </svg>

                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse text-sm">

                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Pegawai
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Device Terdaftar
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Device Percobaan
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                IP Address
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Waktu
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">

                        @forelse($logs as $log)

                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">

                                {{-- PEGAWAI --}}
                                <td class="px-8 py-5">

                                    <div class="flex items-center">

                                        <div class="w-11 h-11 rounded-2xl bg-rose-50/80 dark:bg-rose-500/10 text-rose-700 dark:text-rose-200 flex items-center justify-center font-black text-lg mr-3 ring-1 ring-rose-600/10 shadow-soft group-hover:scale-110 transition-transform">

                                            {{ strtoupper(substr($log->user->tenagaKependidikan->nama ?? $log->user->name ?? 'P', 0, 1)) }}

                                        </div>

                                        <div>
                                            <div class="font-black text-slate-800 dark:text-slate-100">
                                                {{ $log->user->tenagaKependidikan->nama ?? ($log->user->name ?? '-') }}
                                            </div>

                                            <div class="text-[11px] text-slate-500 dark:text-slate-300">
                                                {{ $log->user->tenagaKependidikan->nip ?? '-' }}
                                            </div>
                                        </div>

                                    </div>

                                </td>

                                {{-- DEVICE TERDAFTAR --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-mono font-black bg-emerald-50/80 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200 ring-1 ring-emerald-600/10">

                                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>

                                        {{ $log->registered_device_id ? substr($log->registered_device_id, 0, 12) . '...' : '-' }}

                                    </span>

                                </td>

                                {{-- DEVICE PERCOBAAN --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-mono font-black bg-rose-50/80 text-rose-700 dark:bg-rose-500/10 dark:text-rose-200 ring-1 ring-rose-600/10">

                                        <span class="w-2 h-2 rounded-full bg-rose-500 mr-2"></span>

                                        {{ substr($log->attempted_device_id, 0, 12) }}...

                                    </span>

                                </td>

                                {{-- IP ADDRESS --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 bg-slate-50/70 dark:bg-white/5 rounded-2xl border border-slate-100/70 dark:border-white/10 shadow-soft text-xs font-black text-slate-700 dark:text-slate-200">

                                        {{ $log->ip_address ?? '-' }}

                                    </span>

                                </td>

                                {{-- WAKTU --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 bg-slate-50/70 dark:bg-white/5 rounded-2xl border border-slate-100/70 dark:border-white/10 shadow-soft text-xs font-black text-slate-700 dark:text-slate-200">

                                        {{ $log->attempted_at->isoFormat('DD MMM YYYY, HH:mm') }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-8 py-20 text-center">

                                    <div class="flex flex-col items-center">

                                        <svg class="w-16 h-16 text-gray-200 mb-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>

                                        <p class="text-gray-400 font-medium">
                                            Belum ada percobaan device yang ditolak.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-6 bg-slate-50/60 dark:bg-white/5 border-t border-slate-100/70 dark:border-white/10">

                {{ $logs->links() }}

            </div>

        </div>

    </div>
</x-app-layout>