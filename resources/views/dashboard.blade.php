<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="text-black-70 text-xs font-black uppercase tracking-[0.25em]">Dashboard</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    Ringkasan Akun
                </h2>
                <p class="text-black-70 text-sm font-medium mt-1">
                    Ringkasan aktivitas dan akses cepat ke fitur utama.
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-white/10 ring-1 ring-white/15 text-white">
                    {{ Auth::user()->role->name ?? 'user' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 sm:px-0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">
                                    Selamat datang, <span class="text-[#006fcf] dark:text-indigo-400">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                </h3>
                                <p class="mt-2 text-sm font-medium text-slate-500 dark:text-slate-400">
                                    Anda sudah berhasil masuk ke sistem. Gunakan menu di atas untuk mulai mengelola presensi.
                                </p>
                            </div>
                            <div class="hidden sm:flex w-14 h-14 rounded-3xl bg-gradient-to-tr from-indigo-600 to-sky-500 text-white items-center justify-center shadow-[0_16px_35px_rgba(79,_70,_229,_0.25)]">
                                <span class="text-xl font-black">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white/80 dark:bg-white/10 text-slate-700 dark:text-slate-100 hover:bg-white dark:hover:bg-white/15 ring-1 ring-slate-900/10 dark:ring-white/10 shadow-soft transition">
                                Kelola Profil
                            </a>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition">
                                Buka Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                    <div class="p-6 sm:p-8">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Akun</p>
                        <p class="mt-2 text-lg font-black text-slate-800 dark:text-white break-words">{{ Auth::user()->email ?? '-' }}</p>
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="p-4 rounded-2xl bg-white/70 dark:bg-white/5 ring-1 ring-slate-900/5 dark:ring-white/10">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Role</p>
                                <p class="mt-1 text-sm font-black text-slate-700 dark:text-slate-100">{{ Auth::user()->role->name ?? '-' }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/70 dark:bg-white/5 ring-1 ring-slate-900/5 dark:ring-white/10">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</p>
                                <p class="mt-1 text-sm font-black text-emerald-700 dark:text-emerald-300">Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
