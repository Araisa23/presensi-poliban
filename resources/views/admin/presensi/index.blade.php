<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Seluruh Data Presensi') }}
            </h2>
            <p class="mt-1 text-white/70 text-sm font-medium">Pantau rekaman presensi masuk/pulang dan foto pendukung.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Pegawai</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Tanggal</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Masuk</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Pulang</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Foto</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($presensi as $p)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-black text-slate-800 dark:text-slate-100">{{ $p->user->tenagaKependidikan->nama ?? ($p->user->name ?? '-') }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $p->user->tenagaKependidikan->nip ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('DD MMM YYYY') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1.5 bg-emerald-50/80 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-200 rounded-full text-xs font-black ring-1 ring-emerald-600/10">
                                            {{ $p->jam_masuk ?? '--:--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1.5 bg-amber-50/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-200 rounded-full text-xs font-black ring-1 ring-amber-600/10">
                                            {{ $p->jam_pulang ?? '--:--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($p->foto->count() > 0)
                                            <div class="flex justify-center -space-x-2">
                                                @foreach($p->foto as $f)
                                                    <img src="{{ asset('storage/presensi/' . $f->foto) }}" class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 object-cover shadow-sm hover:scale-150 hover:z-10 transition-transform cursor-pointer" title="Foto Presensi">
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600 text-[10px] font-bold italic uppercase">No Photo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.presensi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi ini? Tindakan ini permanen.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-600 dark:text-rose-300 hover:bg-rose-50/80 dark:hover:bg-rose-500/10 rounded-2xl transition-colors ring-1 ring-transparent hover:ring-rose-600/10">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <span class="text-gray-400 font-medium italic">Belum ada rekaman presensi hari ini.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50/60 dark:bg-white/5 border-t border-slate-100/70 dark:border-white/10">
                    {{ $presensi->links() }}
                </div>
            </div>
    </div>
</x-app-layout>