<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                Tambah Jadwal Kerja
            </h2>

            <p class="mt-1 text-slate-500 text-sm font-medium">
                Atur jadwal kerja mingguan pegawai.
            </p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-soft border border-slate-200 overflow-hidden">

        <form
            action="{{ route('admin.jadwal-kerja.store') }}"
            method="POST"
        >
                @csrf

                <div class="p-8 space-y-8">

                    <div>
                        <x-input-label for="tipe_jadwal" :value="__('Tipe Jadwal')" />

                        <select
                            name="nama_jadwal"
                            id="tipe_jadwal"
                            class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#006fcf] focus:ring-[#006fcf]"
                            required
                        >
                            <option value="">Pilih Jadwal</option>

                            <option value="WFO">
                                WFO (Senin - Kamis)
                            </option>

                            <option value="WFH">
                                WFH (Jumat)
                            </option>
                        </select>

                        <x-input-error :messages="$errors->get('nama_jadwal')" class="mt-2" />
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
                                :value="old('jam_masuk')"
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
                                :value="old('jam_pulang')"
                                required
                            />

                            <x-input-error :messages="$errors->get('jam_pulang')" class="mt-2" />
                        </div>

                    </div>


                    {{-- INFORMASI SISTEM PRESENSI --}}
                    <div class="rounded-3xl border border-blue-100 bg-blue-50 p-5">

                        <div class="flex gap-3">

                            <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                </svg>
                            </div>

                            <div class="flex-1">

                                <h4 class="font-bold text-blue-900">
                                    Informasi Presensi Otomatis
                                </h4>

                                <p class="text-sm text-blue-700 mt-1">
                                    Sistem akan mengatur aturan presensi secara otomatis sesuai jadwal kerja.
                                </p>

                                <div class="grid md:grid-cols-2 gap-5 mt-4">

                                    {{-- BATAS WAKTU --}}
                                    <div>

                                        <p class="text-xs font-black uppercase tracking-wider text-blue-900 mb-2">
                                            Batas Waktu Presensi
                                        </p>

                                        <ul class="text-sm text-blue-700 space-y-1">
                                            <li>• Masuk dimulai 1 jam sebelum jam masuk</li>
                                            <li>• Terlambat maksimal 30 menit setelah jam masuk</li>
                                            <li>• Pulang dimulai tepat jam pulang</li>
                                            <li>• Batas pulang 1 jam setelah jam pulang</li>
                                        </ul>

                                    </div>

                                    {{-- ATURAN PRESENSI --}}
                                    <div>

                                        <p class="text-xs font-black uppercase tracking-wider text-blue-900 mb-2">
                                            Aturan Presensi
                                        </p>

                                        <ul class="text-sm text-blue-700 space-y-1">
                                            <li>• Senin–Kamis: WFO + Lokasi + Selfie</li>
                                            <li>• Jumat: WFH + Selfie</li>
                                            <li>• Validasi lokasi otomatis untuk jadwal WFO</li>
                                            <li>• Selfie wajib pada seluruh jadwal kerja</li>
                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="px-8 py-5 flex justify-end gap-3">

                    {{-- BACK BUTTON --}}
                    <x-back-button href="{{ route('admin.jadwal-kerja.index') }}">
                        Kembali
                    </x-back-button>

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
                        Simpan Jadwal
                    </x-primary-button>

                </div>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>