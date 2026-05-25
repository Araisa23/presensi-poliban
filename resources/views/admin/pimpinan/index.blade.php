<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Data Pimpinan') }}
                </h2>

                <p class="mt-1 text-black-70 text-sm font-medium">
                    Kelola seluruh akun pimpinan sistem presensi.
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition min-w-[180px]">

                + Tambah Pimpinan
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- SUCCESS --}}
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
        <form method="GET" class="mb-6">

            <div class="bg-white dark:bg-slate-900 rounded-3xl 
                border border-slate-100/70 dark:border-white/10 
                shadow-soft p-5">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- SEARCH --}}
                    <div class="md:col-span-2">

                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Cari Pimpinan
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari pimpinan..."
                            class="w-full rounded-2xl border-slate-200
                            dark:border-white/10 bg-white dark:bg-white/5
                            px-4 py-3 text-sm font-medium
                            text-slate-700 dark:text-slate-100
                            focus:ring-2 focus:ring-indigo-500"
                        >

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

                        <a
                            href="{{ route('admin.pimpinan.index') }}"
                            class="inline-flex items-center justify-center 
                            px-5 py-3 rounded-2xl font-black text-xs 
                            uppercase tracking-[0.18em]
                            bg-slate-100 dark:bg-white/5
                            text-slate-600 dark:text-slate-200
                            hover:bg-slate-200 dark:hover:bg-white/10 transition"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            </div>

        </form>

        {{-- CARD --}}
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    {{-- HEAD --}}
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                User
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                NIP
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">
                                Email
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-center">
                                Role
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10 text-right">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">

                        @forelse($pimpinan as $user)

                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors duration-150 group">

                                {{-- USER --}}
                                <td class="px-8 py-5 whitespace-nowrap">

                                    <div class="flex items-center">

                                        {{-- AVATAR --}}
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-50/80 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-200 flex items-center justify-center font-black text-lg mr-3 group-hover:scale-110 transition-transform ring-1 ring-indigo-600/10 shadow-soft">

                                            {{ strtoupper(substr($user->display_name, 0, 1)) }}

                                        </div>

                                        {{-- INFO --}}
                                        <div>

                                            <div class="text-sm font-black text-slate-800 dark:text-slate-100">
                                                {{ $user->display_name }}
                                            </div>

                                            <div class="text-xs text-slate-400">
                                                Pengguna Sistem
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- NIP --}}
                                <td class="px-8 py-5">

                                    <span class="text-xs bg-white/70 dark:bg-white/5 px-3 py-1.5 rounded-full text-slate-600 dark:text-slate-300 font-mono ring-1 ring-slate-900/5 dark:ring-white/10">

                                        {{ $user->display_nip }}

                                    </span>

                                </td>

                                {{-- EMAIL --}}
                                <td class="px-8 py-5">

                                    <span class="text-sm text-slate-600 dark:text-slate-300 font-medium">

                                        {{ $user->email ?? '-' }}

                                    </span>

                                </td>

                                {{-- ROLE --}}
                                <td class="px-8 py-5 text-center">

                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-indigo-50/80 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-200 ring-1 ring-indigo-600/10">

                                        <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>

                                        Pimpinan

                                    </span>

                                </td>

                                {{-- AKSI --}}
                                <td class="px-8 py-5 text-right">

                                    <div class="flex items-center justify-end gap-3"
                                        x-data="{ openDeleteModal: false }">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
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
                                            style="display: none;">

                                            {{-- OVERLAY --}}
                                            <div
                                                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                                @click="openDeleteModal = false">
                                            </div>

                                            {{-- CONTENT --}}
                                            <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden">

                                                <div class="p-8">

                                                    {{-- ICON --}}
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

                                                    {{-- TEXT --}}
                                                    <div class="mt-6 text-center">

                                                        <h3 class="text-xl font-black text-slate-900 dark:text-white">
                                                            Hapus User?
                                                        </h3>

                                                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">

                                                            User
                                                            <span class="font-bold text-rose-600">
                                                                {{ $user->display_name }}
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
                                                            class="px-5 py-2.5 rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-100 dark:hover:bg-slate-700 transition">

                                                            Batal
                                                        </button>

                                                        {{-- DELETE --}}
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
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

                                <td colspan="5" class="px-8 py-20 text-center">

                                    <div class="flex flex-col items-center">

                                        <svg class="w-16 h-16 text-gray-200 mb-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>

                                        <p class="text-gray-400 font-medium">
                                            Belum ada data user.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="p-6 border-t border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5">

                {{ $pimpinan->links() }}

            </div>

        </div>
    </div>
</x-app-layout>