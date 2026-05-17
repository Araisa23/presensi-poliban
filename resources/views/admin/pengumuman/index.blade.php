<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <!-- LEFT -->
            <div>

                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">
                    Admin
                </p>

                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Daftar Pengumuman') }}
                </h2>

                <p class="mt-1 text-white/70 text-sm font-medium">
                    Kelola pengumuman dan informasi penting untuk pegawai.
                </p>

            </div>

            <!-- BUTTON -->
            <a href="{{ route('admin.pengumuman.create') }}"
               class="inline-flex items-center justify-center px-6 py-4 
               rounded-2xl font-black text-xs uppercase tracking-[0.2em] 
               bg-gradient-to-b from-indigo-600 to-indigo-700 
               text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] 
               ring-1 ring-indigo-600/20 transition text-center min-w-[180px]">

                + Tambah Pengumuman

            </a>

        </div>
    </x-slot>

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
                                       dark:border-white/10 text-right">
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
                                <td class="px-6 py-5 text-right">

                                    <div class="inline-flex items-center gap-2">

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
                                        <form action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Hapus pengumuman ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center justify-center 
                                                    px-4 py-2 rounded-2xl text-[11px] 
                                                    font-black uppercase tracking-[0.18em] 
                                                    bg-rose-50/80 dark:bg-rose-500/10 
                                                    text-rose-700 dark:text-rose-200 
                                                    hover:bg-rose-100/70 
                                                    dark:hover:bg-rose-500/15 
                                                    ring-1 ring-rose-600/10 
                                                    dark:ring-rose-500/20 transition">

                                                Hapus

                                            </button>

                                        </form>

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