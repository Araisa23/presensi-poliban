<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <!-- LEFT -->
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Daftar Pengumuman') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
                    Kelola pengumuman dan informasi penting untuk pegawai.
                </p>
            </div>

            <!-- BUTTON -->
            <a href="{{ route('admin.pengumuman.create') }}"
               class="inline-flex items-center justify-center px-6 py-4 
               rounded-2xl font-black text-xs uppercase tracking-[0.2em] 
               bg-gradient-to-r from-[#004b8d] to-[#006fcf] 
               text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] 
               ring-1 ring-indigo-600/20 transition text-center min-w-[180px]">

                + Tambah Pengumuman

            </a>

        </div>
    </x-slot>
    
{{-- FILTER --}}
<div class="mb-6">
    <form method="GET" action="{{ route('admin.pengumuman.index') }}">

        <div class="bg-white dark:bg-slate-900 rounded-3xl 
                    border border-slate-100/70 dark:border-white/10 
                    shadow-soft p-5">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- SEARCH --}}
                <div class="md:col-span-2">

                    <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                        Cari Pengumuman
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul pengumuman..."
                        class="mt-2 w-full rounded-2xl border border-slate-200 
                               dark:border-white/10 bg-white dark:bg-white/5 
                               px-4 py-3 text-sm font-medium 
                               text-slate-700 dark:text-slate-100
                               focus:ring-2 focus:ring-indigo-500"
                    >

                </div>

                {{-- STATUS --}}
                <div>

                    <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                        Status
                    </label>

                    <select
                        name="status"
                        class="mt-2 w-full rounded-2xl border border-slate-200 
                               dark:border-white/10 bg-white dark:bg-white/5 
                               px-4 py-3 text-sm font-medium 
                               text-slate-700 dark:text-slate-100
                               focus:ring-2 focus:ring-indigo-500"
                    >

                        <option value="">Semua</option>

                        <option value="1"
                            {{ request('status') == '1' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ request('status') == '0' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center 
                               px-5 py-3 rounded-2xl font-black text-xs 
                               uppercase tracking-[0.18em]
                               bg-gradient-to-r from-[#004b8d] to-[#006fcf]
                               text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)]
                               hover:scale-[1.01] transition"
                    >

                        Filter

                    </button>

                    <a href="{{ route('admin.pengumuman.index') }}"
                       class="inline-flex items-center justify-center 
                              px-5 py-3 rounded-2xl font-black text-xs 
                              uppercase tracking-[0.18em]
                              bg-slate-100 dark:bg-white/5
                              text-slate-600 dark:text-slate-200
                              hover:bg-slate-200 dark:hover:bg-white/10 transition">

                        Reset

                    </a>

                </div>

            </div>

        </div>

    </form>
</div>

    <div class="max-w-7xl mx-auto">

        <!-- ALERT -->
        @if(session('success'))

            <div class="mb-6 p-4 rounded-2xl 
                        bg-emerald-50/70 dark:bg-emerald-500/10 
                        border border-emerald-200/70 
                        dark:border-emerald-500/20 
                        text-emerald-800 dark:text-emerald-200 
                        shadow-soft">

                {{ session('success') }}

            </div>

        @endif

        <!-- CARD -->
        <div class="bg-white dark:bg-slate-900 overflow-hidden 
                    shadow-soft rounded-3xl 
                    border border-slate-100/70 dark:border-white/10">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <!-- HEAD -->
                    <thead>

                        <tr class="bg-slate-50/70 dark:bg-white/5">

                            <th class="px-6 py-5 text-[10px] font-black 
                                       text-slate-400 uppercase tracking-[0.25em] 
                                       border-b border-slate-100/70 
                                       dark:border-white/10">
                                Judul
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black 
                                       text-slate-400 uppercase tracking-[0.25em] 
                                       border-b border-slate-100/70 
                                       dark:border-white/10">
                                Tanggal
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black 
                                       text-slate-400 uppercase tracking-[0.25em] 
                                       border-b border-slate-100/70 
                                       dark:border-white/10">
                                Status
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black 
                                       text-slate-400 uppercase tracking-[0.25em] 
                                       border-b border-slate-100/70 
                                       dark:border-white/10 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">

                        @forelse($pengumumans as $item)

                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">

                                <!-- JUDUL -->
                                <td class="px-6 py-5">

                                    <div class="text-sm font-black text-slate-800 dark:text-slate-100">
                                        {{ $item->judul }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1 line-clamp-2">
                                        {{ Str::limit($item->isi, 80) }}
                                    </div>

                                </td>

                                <!-- TANGGAL -->
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-300">

                                    {{ $item->tanggal }}

                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-5">

                                    @if($item->status)

                                        <span class="px-3 py-1.5 
                                                     bg-emerald-50/80 dark:bg-emerald-500/10 
                                                     text-emerald-700 dark:text-emerald-200 
                                                     rounded-full text-xs font-black 
                                                     ring-1 ring-emerald-600/10">

                                            Aktif

                                        </span>

                                    @else

                                        <span class="px-3 py-1.5 
                                                     bg-rose-50/80 dark:bg-rose-500/10 
                                                     text-rose-700 dark:text-rose-200 
                                                     rounded-full text-xs font-black 
                                                     ring-1 ring-rose-600/10">

                                            Nonaktif

                                        </span>

                                    @endif

                                </td>

                                <!-- AKSI -->
                                <td class="px-6 py-5 text-center">

                                    <div class="flex items-center justify-center gap-2">

                                        <!-- EDIT -->
                                        <a href="{{ route('admin.pengumuman.edit', $item->id) }}"
                                           class="inline-flex items-center justify-center 
                                           px-4 py-2 rounded-2xl text-[11px] 
                                           font-black uppercase tracking-[0.18em] 
                                           bg-white/80 dark:bg-white/10 
                                           text-slate-700 dark:text-slate-100 
                                           hover:bg-white dark:hover:bg-white/15 
                                           ring-1 ring-slate-900/10 
                                           dark:ring-white/10 shadow-soft transition">

                                            Edit

                                        </a>

                                        <!-- DELETE -->
                                        <div x-data="{ openDeleteModal: false }" class="inline-flex items-center">

                                            {{-- BUTTON DELETE --}}
                                            <button
                                                type="button"
                                                @click="openDeleteModal = true"
                                                class="inline-flex items-center justify-center 
                                                px-4 py-2 rounded-2xl text-[11px] 
                                                font-black uppercase tracking-[0.18em] 
                                                bg-rose-50/80 dark:bg-rose-500/10 
                                                text-rose-700 dark:text-rose-200 
                                                hover:bg-rose-100/70 
                                                dark:hover:bg-rose-500/15 
                                                ring-1 ring-rose-600/10 
                                                dark:ring-rose-500/20 transition"
                                            >
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

                                                {{-- CONTENT --}}
                                                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden">

                                                    <div class="p-8">

                                                        {{-- ICON --}}
                                                        <div class="w-16 h-16 mx-auto rounded-3xl 
                                                                    bg-rose-100 dark:bg-rose-500/10 
                                                                    text-rose-600 dark:text-rose-300 
                                                                    flex items-center justify-center">

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

                                                        {{-- TEXT --}}
                                                        <div class="mt-6 text-center">

                                                            <h3 class="text-xl font-black text-slate-900 dark:text-white">
                                                                Hapus Pengumuman?
                                                            </h3>

                                                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                                                Pengumuman
                                                                <span class="font-bold text-rose-600">
                                                                    {{ $item->judul }}
                                                                </span>
                                                                akan dihapus permanen.
                                                            </p>

                                                        </div>

                                                        {{-- BUTTON --}}
                                                        <div class="mt-8 flex items-center justify-center gap-3">

                                                            {{-- CANCEL --}}
                                                            <button
                                                                type="button"
                                                                @click="openDeleteModal = false"
                                                                class="px-5 py-2.5 rounded-2xl border border-slate-300 dark:border-white/10 
                                                                bg-white dark:bg-slate-800 
                                                                text-slate-700 dark:text-slate-200 
                                                                font-semibold hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                                                            >
                                                                Batal
                                                            </button>

                                                            {{-- DELETE --}}
                                                            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                                                                method="POST">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button
                                                                    type="submit"
                                                                    class="px-5 py-2.5 rounded-2xl 
                                                                    bg-rose-600 text-white 
                                                                    font-semibold hover:bg-rose-700 transition"
                                                                >
                                                                    Ya, Hapus
                                                                </button>

                                                            </form>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="px-6 py-12 text-center 
                                           text-slate-400 font-medium italic">

                                    Belum ada pengumuman.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>