<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.hari-libur.index') }}" class="mr-4 inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-black-70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Hari Libur Baru') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">Tambahkan tanggal libur dan keterangannya.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="p-8 sm:p-10">
                    <form action="{{ route('admin.hari-libur.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <x-input-label for="tanggal" :value="__('Tanggal Libur')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <x-text-input id="tanggal" class="block w-full pl-10 focus:ring-rose-500 focus:border-rose-500" type="date" name="tanggal" :value="old('tanggal')" required />
                                </div>
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="keterangan" :value="__('Keterangan / Alasan')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L13 13l-4 1 1-4 7.5-7.5z"/></svg>
                                    </div>
                                    <x-text-input id="keterangan" class="block w-full pl-10" type="text" name="keterangan" :value="old('keterangan')" placeholder="Contoh: Libur Nasional / Cuti Bersama" />
                                </div>
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                                <p class="text-xs text-gray-400 mt-1">Keterangan ini akan muncul pada laporan presensi pegawai.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-slate-100/70 dark:border-white/10">
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-b from-rose-600 to-rose-700 text-white shadow-[0_14px_30px_rgba(225,_29,_72,_0.25)] ring-1 ring-rose-600/20 transition">
                                {{ __('Simpan Hari Libur') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>
