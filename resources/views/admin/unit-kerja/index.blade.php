<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Daftar Unit Kerja') }}
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Atur struktur organisasi untuk pengelompokan pegawai.</p>
            </div>
            <a href="{{ route('admin.unit-kerja.create') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-indigo-600 to-indigo-700 text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition min-w-[180px]">
                + Tambah Unit
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-500/10 border border-emerald-200/70 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200 shadow-soft">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Nama Unit</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                        @forelse($unitKerja as $unit)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                <td class="px-6 py-5 text-sm font-black text-slate-800 dark:text-slate-100">{{ $unit->nama_unit }}</td>
                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.unit-kerja.edit', $unit->id) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-2xl text-[11px] font-black uppercase tracking-[0.18em] bg-white/80 dark:bg-white/10 text-slate-700 dark:text-slate-100 hover:bg-white dark:hover:bg-white/15 ring-1 ring-slate-900/10 dark:ring-white/10 shadow-soft transition">Edit</a>
                                    <form action="{{ route('admin.unit-kerja.destroy', $unit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus unit ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-2xl text-[11px] font-black uppercase tracking-[0.18em] bg-rose-50/80 dark:bg-rose-500/10 text-rose-700 dark:text-rose-200 hover:bg-rose-100/70 dark:hover:bg-rose-500/15 ring-1 ring-rose-600/10 dark:ring-rose-500/20 transition">Hapus</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada data unit kerja.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6 border-t border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5">
                    {{ $unitKerja->links() }}
                </div>
            </div>
    </div>
</x-app-layout>
