<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">

            <!-- BACK -->
            <a href="{{ route('admin.pengumuman.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-2xl 
               bg-white/10 text-white hover:bg-white/15 
               ring-1 ring-white/15 shadow-soft transition">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>

            </a>

            <!-- TITLE -->
            <div>

                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">
                    Admin
                </p>

                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Pengumuman') }}
                </h2>

                <p class="mt-1 text-white/70 text-sm font-medium">
                    Kelola informasi dan pengumuman penting untuk tenaga kependidikan.
                </p>

            </div>

        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white dark:bg-slate-900 overflow-hidden 
                    shadow-soft rounded-3xl p-6 sm:p-8 
                    border border-slate-100/70 dark:border-white/10">

            <form method="POST"
                  action="{{ route('admin.pengumuman.store') }}"
                  class="space-y-6">

                @csrf

                <div class="grid grid-cols-1 gap-6">

                    <!-- JUDUL -->
                    <div>

                        <x-input-label for="judul" :value="__('Judul Pengumuman')" />

                        <x-text-input
                            id="judul"
                            class="block mt-2 w-full"
                            type="text"
                            name="judul"
                            :value="old('judul')"
                            required
                        />

                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />

                    </div>

                    <!-- TANGGAL -->
                    <div>

                        <x-input-label for="tanggal" :value="__('Tanggal')" />

                        <x-text-input
                            id="tanggal"
                            class="block mt-2 w-full"
                            type="date"
                            name="tanggal"
                            :value="old('tanggal')"
                            required
                        />

                        <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />

                    </div>

                    <!-- ISI -->
                    <div>

                        <x-input-label for="isi" :value="__('Isi Pengumuman')" />

                        <textarea
                            id="isi"
                            name="isi"
                            rows="6"
                            class="block mt-2 w-full border-slate-200 
                                   dark:border-white/10 
                                   bg-white/80 dark:bg-white/5 
                                   text-slate-900 dark:text-slate-100
                                   focus:border-indigo-500 
                                   focus:ring-indigo-500 
                                   rounded-2xl shadow-soft 
                                   ring-1 ring-slate-900/5 
                                   dark:ring-white/10 transition"
                            required>{{ old('isi') }}</textarea>

                        <x-input-error :messages="$errors->get('isi')" class="mt-2" />

                    </div>

                    <!-- STATUS -->
                    <div>

                        <x-input-label for="status" :value="__('Status')" />

                        <select
                            id="status"
                            name="status"
                            class="block mt-2 w-full border-slate-200 
                                   dark:border-white/10 
                                   bg-white/80 dark:bg-white/5 
                                   text-slate-900 dark:text-slate-100
                                   focus:border-indigo-500 
                                   focus:ring-indigo-500 
                                   rounded-2xl shadow-soft 
                                   ring-1 ring-slate-900/5 
                                   dark:ring-white/10 transition">

                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>

                        </select>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="flex items-center justify-end pt-4">

                    <x-primary-button>
                        {{ __('Simpan Pengumuman') }}
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>