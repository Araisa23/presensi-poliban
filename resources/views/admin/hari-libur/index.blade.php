<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
            <p class="text-black-70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Manajemen Hari Libur Khusus') }}
            </h2>
            <p class="mt-1 text-black-70 text-sm font-medium">Tambahkan libur khusus (nasional/cuti bersama) untuk laporan presensi.</p>
            </div>
            <a href="{{ route('admin.hari-libur.create') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-rose-600 to-rose-700 text-white shadow-[0_14px_30px_rgba(225,_29,_72,_0.25)] ring-1 ring-rose-600/20 transition min-w-[200px]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Libur
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
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Tanggal</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Keterangan / Alasan Libur</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($hariLiburs as $libur)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-3xl bg-rose-50/80 dark:bg-rose-500/10 text-rose-700 dark:text-rose-200 flex flex-col items-center justify-center font-black mr-4 group-hover:scale-105 transition-transform shadow-soft ring-1 ring-rose-600/10">
                                                <span class="text-xs uppercase leading-none mb-1 opacity-70">{{ \Carbon\Carbon::parse($libur->tanggal)->format('M') }}</span>
                                                <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($libur->tanggal)->format('d') }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-black text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($libur->tanggal)->translatedFormat('l') }}</span>
                                                <span class="block text-xs text-slate-400 dark:text-slate-500">{{ \Carbon\Carbon::parse($libur->tanggal)->format('Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 rounded-full bg-rose-400 mr-3"></div>
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ $libur->keterangan ?? 'Tanpa Keterangan' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.hari-libur.edit', $libur->id) }}" class="p-2 text-indigo-700 dark:text-indigo-200 hover:bg-indigo-50/80 dark:hover:bg-indigo-500/10 rounded-2xl transition-colors ring-1 ring-transparent hover:ring-indigo-600/10" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L13 13l-4 1 1-4 7.5-7.5z"/></svg>
                                            </a>
                                            <form action="{{ route('admin.hari-libur.destroy', $libur->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus hari libur ini?')">
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
                                    <td colspan="3" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p class="text-gray-400 font-medium">Belum ada daftar hari libur khusus.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($hariLiburs->hasPages())
                    <div class="p-8 bg-slate-50/60 dark:bg-white/5 border-t border-slate-100/70 dark:border-white/10">
                        {{ $hariLiburs->links() }}
                    </div>
                @endif
            </div>
    </div>
</x-app-layout>
