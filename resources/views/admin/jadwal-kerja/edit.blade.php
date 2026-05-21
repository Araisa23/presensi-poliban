<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                Edit Jadwal Kerja
            </h2>

            <p class="mt-1 text-slate-500 text-sm font-medium">
                Perbarui jadwal kerja dan pengaturan presensi.
            </p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-soft border border-slate-200 overflow-hidden">

            <form action="{{ route('admin.jadwal-kerja.update', $jadwalKerja->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="p-8 space-y-8">

                    {{-- NAMA JADWAL --}}
                    <div>
                        <x-input-label for="nama_jadwal" :value="__('Nama Jadwal')" />

                        <x-text-input
                            id="nama_jadwal"
                            class="block mt-2 w-full"
                            type="text"
                            name="nama_jadwal"
                            :value="old('nama_jadwal', $jadwalKerja->nama_jadwal)"
                            required
                        />

                        <x-input-error :messages="$errors->get('nama_jadwal')" class="mt-2" />
                    </div>

                    {{-- PILIH HARI --}}
                    <div>
                        <x-input-label :value="__('Pilih Hari')" />

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">

                            @php
                                $selectedHari = old('hari', json_decode($jadwalKerja->hari, true) ?? []);
                            @endphp

                            @foreach ([
                                'Senin',
                                'Selasa',
                                'Rabu',
                                'Kamis',
                                'Jumat'
                            ] as $hari)

                                <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 cursor-pointer hover:border-indigo-400 transition">

                                    <input
                                        type="checkbox"
                                        name="hari[]"
                                        value="{{ $hari }}"
                                        class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        {{ in_array($hari, $selectedHari) ? 'checked' : '' }}
                                    >

                                    <span class="font-semibold text-slate-700">
                                        {{ $hari }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                        <x-input-error :messages="$errors->get('hari')" class="mt-2" />
                    </div>

                    {{-- JAM --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <x-input-label for="jam_masuk" :value="__('Jam Masuk')" />

                            <x-text-input
                                id="jam_masuk"
                                class="block mt-2 w-full"
                                type="time"
                                name="jam_masuk"
                                :value="old('jam_masuk', $jadwalKerja->jam_masuk)"
                                required
                            />

                            <x-input-error :messages="$errors->get('jam_masuk')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jam_pulang" :value="__('Jam Pulang')" />

                            <x-text-input
                                id="jam_pulang"
                                class="block mt-2 w-full"
                                type="time"
                                name="jam_pulang"
                                :value="old('jam_pulang', $jadwalKerja->jam_pulang)"
                                required
                            />

                            <x-input-error :messages="$errors->get('jam_pulang')" class="mt-2" />
                        </div>

                    </div>

                    {{-- PENGATURAN --}}
                    <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200">

                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-500 mb-5">
                            Pengaturan Presensi
                        </h3>

                        <div class="space-y-5">

                            {{-- WFH --}}
                            <label class="flex items-start gap-4 cursor-pointer">

                                <input
                                    type="checkbox"
                                    name="is_wfh"
                                    value="1"
                                    class="mt-1 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ old('is_wfh', $jadwalKerja->is_wfh) ? 'checked' : '' }}
                                >

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Mode WFH
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Pegawai dapat presensi dari luar kantor.
                                    </p>
                                </div>

                            </label>

                            {{-- VALIDASI LOKASI --}}
                            <label class="flex items-start gap-4 cursor-pointer">

                                <input
                                    type="checkbox"
                                    name="use_location"
                                    value="1"
                                    class="mt-1 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ old('use_location', $jadwalKerja->use_location) ? 'checked' : '' }}
                                >

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Gunakan Validasi Lokasi
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Sistem mengecek radius kantor saat presensi.
                                    </p>
                                </div>

                            </label>

                            {{-- SELFIE --}}
                            <label class="flex items-start gap-4 cursor-pointer">

                                <input
                                    type="checkbox"
                                    name="use_camera"
                                    value="1"
                                    class="mt-1 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ old('use_camera', $jadwalKerja->use_camera) ? 'checked' : '' }}
                                >

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Wajib Selfie Kamera
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Pegawai wajib selfie saat presensi.
                                    </p>
                                </div>

                            </label>

                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="px-8 py-5 flex justify-end gap-3 border-t border-slate-200">

                    {{-- BACK BUTTON --}}
                    <a href="{{ route('admin.jadwal-kerja.index') }}"
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

                        Simpan Perubahan
                    </x-primary-button>

                </div>

            </form>

        </div>
    </div>
</x-app-layout>