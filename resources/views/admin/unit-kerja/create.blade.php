<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.unit-kerja.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Unit Kerja') }}
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Buat unit untuk pengelompokan pegawai.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                <form action="{{ route('admin.unit-kerja.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-input-label for="nama_unit" :value="__('Nama Unit Kerja')" />
                        <x-text-input id="nama_unit" class="block mt-1 w-full" type="text" name="nama_unit" :value="old('nama_unit')" required autofocus />
                        <x-input-error :messages="$errors->get('nama_unit')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
