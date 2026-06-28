    <x-app-layout>
        <x-slot name="header">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Daftar Unit Kerja') }}
                    </h2>
                    <p class="mt-1 text-black-70 text-sm font-medium">Atur struktur organisasi untuk pengelompokan pegawai.</p>
                </div>
                <a href="{{ route('admin.unit-kerja.create') }}" 
                    class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] 
                    text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 hover:scale-[1.02] transition min-w-[180px]">
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

                {{-- ERROR --}}
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50/70 border border-rose-200 text-rose-800 shadow-soft">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 dark:bg-white/5">
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Nama Unit</th>
                                <th class="px-6 py-5 border-b border-slate-100/70 dark:border-white/10">
                                    <div class="flex justify-end">
                                        <div class="relative inline-flex items-center gap-2">
                                            <span class="invisible inline-flex items-center justify-center px-4 py-2 rounded-2xl border border-slate-200 text-xs font-black uppercase tracking-[0.15em]">Edit</span>
                                            <span class="invisible inline-flex items-center justify-center px-4 py-2 rounded-2xl border border-red-200 text-xs font-black uppercase tracking-[0.15em]">Hapus</span>
                                            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] whitespace-nowrap">Aksi</span>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                            @forelse($unitKerja as $unit)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">

                                {{-- NAMA UNIT --}}
                                <td class="px-6 py-5 text-sm font-black text-slate-800 dark:text-slate-100">
                                    {{ $unit->nama_unit }}
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-5">

                                    <div class="flex justify-end"
                                        x-data="{ openDeleteModal: false }">

                                        <div class="relative inline-flex items-center gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.unit-kerja.edit', $unit->id) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 text-xs font-black uppercase tracking-[0.15em] hover:bg-slate-100 transition">

                                            Edit
                                        </a>

                                        {{-- DELETE BUTTON --}}
                                        <button
                                            type="button"
                                            @click="openDeleteModal = true"
                                            class="inline-flex items-center justify-center px-4 py-2 rounded-2xl border border-red-200 text-red-600 text-xs font-black uppercase tracking-[0.15em] hover:bg-red-50 transition"
                                        >
                                            Hapus
                                        </button>

                                        </div>

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

                                            {{-- MODAL CARD --}}
                                            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

                                                <div class="p-8">

                                                    {{-- ICON --}}
                                                    <div class="w-16 h-16 mx-auto rounded-3xl bg-red-100 text-red-600 flex items-center justify-center">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-8 h-8"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor">

                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-1-3H10a1 1 0 00-1 1v2h6V5a1 1 0 00-1-1z" />
                                                        </svg>

                                                    </div>

                                                    {{-- TEXT --}}
                                                    <div class="mt-6 text-center">

                                                        <h3 class="text-xl font-black text-slate-900">
                                                            Hapus Data?
                                                        </h3>

                                                        <p class="mt-2 text-slate-500 text-sm leading-relaxed">
                                                            Data yang dihapus tidak dapat dikembalikan lagi.
                                                        </p>

                                                    </div>

                                                    {{-- ACTION --}}
                                                    <div class="mt-8 flex items-center justify-center gap-3">

                                                        {{-- CANCEL --}}
                                                        <button
                                                            type="button"
                                                            @click="openDeleteModal = false"
                                                            class="px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition"
                                                        >
                                                            Batal
                                                        </button>

                                                        {{-- DELETE --}}
                                                        <form action="{{ route('admin.unit-kerja.destroy', $unit->id) }}"
                                                            method="POST">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="px-5 py-2.5 rounded-2xl bg-red-600 text-white font-semibold hover:bg-red-700 transition"
                                                            >
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
