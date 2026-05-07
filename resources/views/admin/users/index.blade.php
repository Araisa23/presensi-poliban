<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
            <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Daftar User') }}
            </h2>
            <p class="mt-1 text-white/70 text-sm font-medium">Kelola akun, email, dan role pengguna.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-indigo-600 to-indigo-700 text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition min-w-[180px]">
                + Tambah User
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-slate-900 shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Nama</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Email</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b border-slate-100/70 dark:border-white/10">Role</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                                <td class="px-6 py-5">
                                    <div class="text-sm font-black text-slate-800 dark:text-slate-100">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-5 text-sm font-medium text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                                <td>
                                    @if($user->role_id == 1)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black bg-indigo-50/80 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-200 ring-1 ring-indigo-600/10">Admin</span>
                                    @elseif($user->role_id == 2)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black bg-emerald-50/80 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-200 ring-1 ring-emerald-600/10">Pegawai</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black bg-amber-50/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-200 ring-1 ring-amber-600/10">Kepala</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </div>
</x-app-layout>