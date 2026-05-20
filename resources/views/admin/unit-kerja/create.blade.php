<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Unit Kerja') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">Buat unit untuk pengelompokan pegawai.</p>
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

                    <!-- FOOTER -->
                    <div class="flex items-center justify-end mt-6 gap-3">

                    {{-- BACK BUTTON --}}
                    <a href="{{ route('admin.unit-kerja.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>

                        Kembali
                    </a>

                    {{-- SAVE BUTTON --}}
                    <x-primary-button class="gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Unit
                    </x-primary-button>

                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
