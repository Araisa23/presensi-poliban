<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Konfigurasi Jadwal Kerja') }}
            </h2>
            <p class="mt-1 text-black-70 text-sm font-medium">Atur jam masuk/pulang, status libur, dan jadwal operasional.</p>
            </div>
            <a href="{{ route('admin.jadwal-kerja.create') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-indigo-600 to-indigo-700 text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition min-w-[180px]">
                + Tambah Jadwal
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

            {{-- FILTER --}}
            <form method="GET" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- SEARCH --}}
                    <div>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari hari / nama jadwal..."
                            class="w-full rounded-2xl border-slate-200"
                        >
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <select
                            name="status"
                            class="w-full rounded-2xl border-slate-200"
                        >
                            <option value="">Semua Status</option>

                            <option value="aktif"
                                {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                Hari Kerja
                            </option>

                            <option value="libur"
                                {{ request('status') == 'libur' ? 'selected' : '' }}>
                                Hari Libur
                            </option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="px-5 py-2 rounded-2xl bg-indigo-600 text-white font-bold"
                        >
                            Filter
                        </button>

                        <a
                            href="{{ route('admin.jadwal-kerja.index') }}"
                            class="px-5 py-2 rounded-2xl bg-slate-200 font-bold"
                        >
                            Reset
                        </a>

                    </div>

                </div>
            </form>

            <!-- TABLE -->
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Hari</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Jam Operasional</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">Status Kerja</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-right">Aksi</th>
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

                                        <div class="flex items-center justify-end gap-3"
                                            x-data="{ openDeleteModal: false }">

                                            {{-- EDIT --}}
                                            <a href="{{ route('admin.jadwal-kerja.edit', $jadwal->id) }}"
                                            class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.15em] text-indigo-700 dark:text-indigo-200 bg-indigo-50/80 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition ring-1 ring-indigo-600/10">

                                                Edit
                                            </a>

                                            {{-- DELETE --}}
                                            <button
                                                type="button"
                                                @click="openDeleteModal = true"
                                                class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.15em] text-rose-700 dark:text-rose-200 bg-rose-50/80 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 transition ring-1 ring-rose-600/10">

                                                Hapus
                                            </button>

                                            {{-- MODAL --}}
                                            <div
                                                x-show="openDeleteModal"
                                                x-transition
                                                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                                style="display: none;"
                                            >

                                                {{-- OVERLAY --}}
                                                <div
                                                    class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                                    @click="openDeleteModal = false"
                                                ></div>

                                                {{-- MODAL --}}
                                                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden">

                                                    <div class="p-8">

                                                        <div class="w-16 h-16 mx-auto rounded-3xl bg-rose-100 dark:bg-rose-500/10 text-rose-600 dark:text-rose-300 flex items-center justify-center">

                                                            <svg class="w-8 h-8"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24">

                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
                                                            </svg>

                                                        </div>

                                                        <div class="mt-6 text-center">

                                                            <h3 class="text-xl font-black text-slate-900 dark:text-white">
                                                                Hapus Jadwal?
                                                            </h3>

                                                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                                                Jadwal kerja hari
                                                                <span class="font-bold text-rose-600">
                                                                    {{ $jadwal->hari }}
                                                                </span>
                                                                akan dihapus permanen.
                                                            </p>

                                                        </div>

                                                        <div class="mt-8 flex items-center justify-center gap-3">

                                                            {{-- CANCEL --}}
                                                            <button
                                                                type="button"
                                                                @click="openDeleteModal = false"
                                                                class="px-5 py-2.5 rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-100 dark:hover:bg-slate-700 transition">

                                                                Batal
                                                            </button>

                                                            {{-- DELETE --}}
                                                            <form action="{{ route('admin.jadwal-kerja.destroy', $jadwal->id) }}"
                                                                method="POST">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button
                                                                    type="submit"
                                                                    class="px-5 py-2.5 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition">

                                                                    Ya, Hapus
                                                                </button>

                                                            </form>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

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
