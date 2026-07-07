<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Seluruh Data Presensi') }}
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Pantau rekaman presensi masuk/pulang dan foto pendukung.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a href="{{ route('admin.presensi.export.excel', [
                    'tanggal' => request('tanggal') ?? now()->toDateString()
                ]) }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                        bg-emerald-600 text-white text-xs font-black
                        uppercase tracking-[0.18em]
                        shadow-sm hover:bg-emerald-700
                        hover:scale-[1.02] transition">

                    Export Excel
                </a>

                <a href="{{ route('admin.presensi.export.pdf', [
                    'tanggal' => request('tanggal') ?? now()->toDateString()
                ]) }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                        bg-rose-600 text-white text-xs font-black
                        uppercase tracking-[0.18em]
                        shadow-sm hover:bg-rose-700
                        hover:scale-[1.02] transition">

                    Export PDF
                </a>

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

        {{-- FILTER --}}
        <form method="GET" action="{{ route('admin.presensi.index') }}" class="mb-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft p-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    <div class="md:col-span-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Pilih Tanggal Presensi
                        </label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)] hover:scale-[1.01] transition">
                            Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse text-sm">

                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Pegawai
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Tanggal
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Jam Masuk
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Jam Pulang
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Foto
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">

                        @forelse($presensi as $p)

                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">

                                {{-- PEGAWAI --}}
                                <td class="px-8 py-5">

                                    <div class="flex items-center">

                                        <div class="w-11 h-11 rounded-2xl bg-indigo-50/80 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-200 flex items-center justify-center font-black text-lg mr-3 ring-1 ring-indigo-600/10 shadow-soft group-hover:scale-110 transition-transform">

                                            {{ strtoupper(substr($p->user->tenagaKependidikan->nama ?? 'P', 0, 1)) }}

                                        </div>

                                        <div>
                                            <div class="font-black text-slate-800 dark:text-slate-100">
                                                {{ $p->user->tenagaKependidikan->nama ?? ($p->user->name ?? '-') }}
                                            </div>

                                            <div class="text-[11px] text-slate-500 dark:text-slate-300">
                                                {{ $p->user->tenagaKependidikan->nip ?? '-' }}
                                            </div>
                                        </div>

                                    </div>

                                </td>

                                {{-- TANGGAL --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 bg-slate-50/70 dark:bg-white/5 rounded-2xl border border-slate-100/70 dark:border-white/10 shadow-soft text-xs font-black text-slate-700 dark:text-slate-200">

                                        {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('DD MMM YYYY') }}

                                    </span>

                                </td>

                                {{-- MASUK --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-emerald-50/80 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200 ring-1 ring-emerald-600/10">

                                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>

                                        {{ $p->jam_masuk ?? '--:--' }}

                                    </span>

                                </td>

                                {{-- PULANG --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-amber-50/80 text-amber-700 dark:bg-amber-500/10 dark:text-amber-200 ring-1 ring-amber-600/10">

                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span>

                                        {{ $p->jam_pulang ?? '--:--' }}

                                    </span>

                                </td>

                                {{-- FOTO --}}
                                <td class="px-8 py-5 text-center">

                                    @if($p->foto->count() > 0)

                                        <div class="flex justify-center -space-x-2">

                                            @foreach($p->foto as $f)

                                                <img
                                                    src="{{ asset('storage/presensi/' . $f->foto) }}"
                                                    class="w-11 h-11 rounded-full border-2 border-white dark:border-gray-800 object-cover shadow-sm hover:scale-150 hover:z-10 transition-transform cursor-pointer"
                                                    title="Foto Presensi"
                                                >

                                            @endforeach

                                        </div>

                                    @else

                                        <span class="text-gray-300 dark:text-gray-600 text-[10px] font-bold italic uppercase">
                                            No Photo
                                        </span>

                                    @endif

                                </td>

                                {{-- AKSI --}}
                                <td class="px-8 py-5 text-center">

                                    <a href="{{ route('admin.presensi.show', $p->id) }}"
                                        class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.15em] text-indigo-700 dark:text-indigo-200 bg-indigo-50/80 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition ring-1 ring-indigo-600/10">

                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-8 py-20 text-center">

                                    <div class="flex flex-col items-center">

                                        <svg class="w-16 h-16 text-gray-200 mb-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>

                                        <p class="text-gray-400 font-medium">
                                            Belum ada rekaman presensi.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-6 bg-slate-50/60 dark:bg-white/5 border-t border-slate-100/70 dark:border-white/10">

                {{ $presensi->appends(request()->except('page'))->links() }}

            </div>

        </div>

    </div>
</x-app-layout>