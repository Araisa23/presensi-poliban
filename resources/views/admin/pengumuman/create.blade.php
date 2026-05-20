<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">

            <!-- TITLE -->
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Pengumuman') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
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

                <!-- FOOTER -->
                <div class="px-8 py-5 border-t border-slate-200 bg-slate-50 flex justify-end gap-3">

                    {{-- BACK BUTTON --}}
                    <a href="{{ route('admin.pengumuman.index') }}"
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
                        Simpan Pengumuman
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>