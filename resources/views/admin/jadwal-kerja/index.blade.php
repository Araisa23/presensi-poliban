<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
            <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Konfigurasi Jadwal Kerja') }}
            </h2>
            <p class="mt-1 text-white/70 text-sm font-medium">Atur jam masuk/pulang, status libur, dan jadwal operasional.</p>
            </div>
            <a href="{{ route('admin.jadwal-kerja.create') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-indigo-600 to-indigo-700 text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition min-w-[200px]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Jadwal
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-500/10 border border-emerald-200/70 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200 shadow-soft flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Hari</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Jam Operasional</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Status Kerja</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-right">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($jadwalKerja as $jadwal)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-2xl bg-indigo-50/80 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-200 flex items-center justify-center font-black text-lg mr-3 group-hover:scale-110 transition-transform ring-1 ring-indigo-600/10 shadow-soft">
                                                {{ substr($jadwal->hari, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-black text-slate-800 dark:text-slate-100">{{ $jadwal->hari }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @if(!$jadwal->is_libur)
                                            <div class="inline-flex items-center px-4 py-2 bg-slate-50/70 dark:bg-white/5 rounded-2xl border border-slate-100/70 dark:border-white/10 shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10">
                                                <span class="text-sm font-black text-indigo-700 dark:text-indigo-200 tabular-nums">{{ \Carbon\Carbon::parse($jadwal->jam_masuk)->format('H:i') }}</span>
                                                <span class="mx-2 text-slate-300 dark:text-slate-600">—</span>
                                                <span class="text-sm font-black text-rose-700 dark:text-rose-200 tabular-nums">{{ \Carbon\Carbon::parse($jadwal->jam_pulang)->format('H:i') }}</span>
                                            </div>
                                        @else
                                            <span class="text-xs font-medium text-gray-400 italic">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @if($jadwal->is_libur)
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-rose-50/80 text-rose-700 dark:bg-rose-500/10 dark:text-rose-200 ring-1 ring-rose-600/10">
                                                <span class="w-2 h-2 rounded-full bg-rose-500 mr-2 animate-pulse"></span>
                                                Libur
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-emerald-50/80 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200 ring-1 ring-emerald-600/10">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                                                Masuk
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.jadwal-kerja.edit', $jadwal->id) }}" class="p-2 text-indigo-700 dark:text-indigo-200 hover:bg-indigo-50/80 dark:hover:bg-indigo-500/10 rounded-2xl transition-colors ring-1 ring-transparent hover:ring-indigo-600/10" title="Edit Jadwal">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L13 13l-4 1 1-4 7.5-7.5z"/></svg>
                                            </a>
                                            <form action="{{ route('admin.jadwal-kerja.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal hari {{ $jadwal->hari }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-700 dark:text-rose-200 hover:bg-rose-50/80 dark:hover:bg-rose-500/10 rounded-2xl transition-colors ring-1 ring-transparent hover:ring-rose-600/10" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <p class="text-gray-400 font-medium">Belum ada konfigurasi jadwal kerja.</p>
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
