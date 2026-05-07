<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.jadwal-kerja.index') }}" class="mr-4 inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Edit Jadwal: ') }} <span class="text-white/90">{{ $jadwalKerja->hari }}</span>
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Ubah jam operasional atau set sebagai hari libur.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="p-8 sm:p-10">
                    <form action="{{ route('admin.jadwal-kerja.update', $jadwalKerja->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PATCH')
                        
                        <div class="bg-slate-50/70 dark:bg-white/5 p-6 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <x-input-label for="hari" :value="__('Hari Operasional')" class="mb-3" />
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-50/80 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-200 flex items-center justify-center font-black text-lg mr-3 ring-1 ring-indigo-600/10 shadow-soft">
                                    {{ substr($jadwalKerja->hari, 0, 1) }}
                                </div>
                                <span class="text-lg font-black text-slate-800 dark:text-slate-100">{{ $jadwalKerja->hari }}</span>
                            </div>
                            <input type="hidden" name="hari" value="{{ $jadwalKerja->hari }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <x-input-label for="jam_masuk" :value="__('Jam Mulai Kerja')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <x-text-input id="jam_masuk" class="block w-full pl-10" type="time" name="jam_masuk" :value="old('jam_masuk', $jadwalKerja->jam_masuk)" required />
                                </div>
                                <x-input-error :messages="$errors->get('jam_masuk')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="jam_pulang" :value="__('Jam Selesai Kerja')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <x-text-input id="jam_pulang" class="block w-full pl-10" type="time" name="jam_pulang" :value="old('jam_pulang', $jadwalKerja->jam_pulang)" required />
                                </div>
                                <x-input-error :messages="$errors->get('jam_pulang')" class="mt-2" />
                            </div>
                        </div>

                        <div class="relative flex items-start gap-3 p-5 bg-slate-50/70 dark:bg-white/5 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <div class="flex items-center h-5">
                                <input id="is_libur" type="checkbox" name="is_libur" value="1" {{ old('is_libur', $jadwalKerja->is_libur) ? 'checked' : '' }} class="mt-1 w-5 h-5 text-indigo-600 bg-white border-slate-200 rounded-lg focus:ring-indigo-500 focus:ring-2 transition-all cursor-pointer dark:bg-white/10 dark:border-white/10">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_libur" class="font-black text-slate-800 dark:text-slate-100 cursor-pointer">Tetapkan sebagai Hari Libur</label>
                                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Pegawai tidak diwajibkan melakukan presensi pada hari ini.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-slate-100/70 dark:border-white/10">
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>
