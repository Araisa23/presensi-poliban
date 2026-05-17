<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.jadwal-kerja.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Jadwal Kerja') }}
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Lengkapi jam operasional dan batas presensi.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                <form action="{{ route('admin.jadwal-kerja.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-4">

                        {{-- HARI --}}
                        <div>
                            <x-input-label for="hari" :value="__('Hari')" />
                            <select id="hari" name="hari" class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition" required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ old('hari') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('hari')" class="mt-2" />
                        </div>

                        {{-- JAM MASUK & JAM PULANG --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="jam_masuk" :value="__('Jam Masuk')" />
                                <x-text-input id="jam_masuk" class="block mt-1 w-full" type="time" name="jam_masuk" :value="old('jam_masuk')" required />
                                <x-input-error :messages="$errors->get('jam_masuk')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jam_pulang" :value="__('Jam Pulang')" />
                                <x-text-input id="jam_pulang" class="block mt-1 w-full" type="time" name="jam_pulang" :value="old('jam_pulang')" required />
                                <x-input-error :messages="$errors->get('jam_pulang')" class="mt-2" />
                            </div>
                        </div>

                        {{-- BATAS PRESENSI MASUK --}}
                        <div class="p-6 bg-slate-50/70 dark:bg-white/5 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <h3 class="text-[10px] font-black text-indigo-600 dark:text-indigo-300 mb-4 uppercase tracking-[0.2em]">Batas Waktu Presensi Masuk</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="batas_awal_masuk" :value="__('Mulai Bisa Presensi Masuk')" />
                                    <x-text-input id="batas_awal_masuk" class="block mt-1 w-full" type="time" name="batas_awal_masuk" :value="old('batas_awal_masuk')" />
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk default (1 jam sebelum jam masuk)</p>
                                    <x-input-error :messages="$errors->get('batas_awal_masuk')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="batas_akhir_masuk" :value="__('Batas Akhir Presensi Masuk')" />
                                    <x-text-input id="batas_akhir_masuk" class="block mt-1 w-full" type="time" name="batas_akhir_masuk" :value="old('batas_akhir_masuk')" />
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk default (30 menit setelah jam masuk)</p>
                                    <x-input-error :messages="$errors->get('batas_akhir_masuk')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- BATAS PRESENSI PULANG --}}
                        <div class="p-6 bg-slate-50/70 dark:bg-white/5 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <h3 class="text-[10px] font-black text-emerald-600 dark:text-emerald-300 mb-4 uppercase tracking-[0.2em]">Batas Waktu Presensi Pulang</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="batas_awal_pulang" :value="__('Mulai Bisa Presensi Pulang')" />
                                    <x-text-input id="batas_awal_pulang" class="block mt-1 w-full" type="time" name="batas_awal_pulang" :value="old('batas_awal_pulang')" />
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk default (tepat jam pulang)</p>
                                    <x-input-error :messages="$errors->get('batas_awal_pulang')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="batas_akhir_pulang" :value="__('Batas Akhir Presensi Pulang')" />
                                    <x-text-input id="batas_akhir_pulang" class="block mt-1 w-full" type="time" name="batas_akhir_pulang" :value="old('batas_akhir_pulang')" />
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk default (1 jam setelah jam pulang)</p>
                                    <x-input-error :messages="$errors->get('batas_akhir_pulang')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- IS LIBUR --}}
                        <div class="flex items-start gap-3 p-5 rounded-3xl bg-slate-50/70 dark:bg-white/5 border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <input id="is_libur" type="checkbox" name="is_libur" value="1" {{ old('is_libur') ? 'checked' : '' }} class="mt-1 w-5 h-5 text-indigo-600 bg-white border-slate-200 rounded-lg focus:ring-indigo-500 focus:ring-2 dark:bg-white/10 dark:border-white/10">
                            <div>
                                <label for="is_libur" class="text-sm font-black text-slate-800 dark:text-slate-100">Tandai sebagai hari libur rutin</label>
                                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Jika dicentang, presensi dinonaktifkan pada hari tersebut.</p>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Simpan Jadwal') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        {{-- WFH --}}
        <div class="flex items-start gap-3 p-5 rounded-3xl bg-slate-50 border border-slate-200">

            <input
                id="is_wfh"
                type="checkbox"
                name="is_wfh"
                value="1"
                class="mt-1 w-5 h-5 rounded-lg">

            <div>
                <label for="is_wfh"
                    class="text-sm font-black text-slate-800">
                    Mode WFH
                </label>

                <p class="text-xs text-slate-500 mt-1">
                    Jika aktif maka pegawai bisa presensi dari luar kantor.
                </p>
            </div>
        </div>

        {{-- USE LOCATION --}}
        <div class="flex items-start gap-3 p-5 rounded-3xl bg-slate-50 border border-slate-200">

            <input
                id="use_location"
                type="checkbox"
                name="use_location"
                value="1"
                checked
                class="mt-1 w-5 h-5 rounded-lg">

            <div>
                <label for="use_location"
                    class="text-sm font-black text-slate-800">
                    Gunakan Validasi Lokasi
                </label>

                <p class="text-xs text-slate-500 mt-1">
                    Sistem akan mengecek radius kantor.
                </p>
            </div>
        </div>

        {{-- USE CAMERA --}}
        <div class="flex items-start gap-3 p-5 rounded-3xl bg-slate-50 border border-slate-200">

            <input
                id="use_camera"
                type="checkbox"
                name="use_camera"
                value="1"
                checked
                class="mt-1 w-5 h-5 rounded-lg">

            <div>
                <label for="use_camera"
                    class="text-sm font-black text-slate-800">
                    Wajib Selfie Kamera
                </label>

                <p class="text-xs text-slate-500 mt-1">
                    Pegawai wajib mengambil foto selfie saat presensi.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>