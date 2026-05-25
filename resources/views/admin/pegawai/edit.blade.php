<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Edit Tenaga Kependidikan') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">Perbarui data pegawai tanpa mengubah akun user terhubung.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NIP -->
                <div>
                    <x-input-label for="nip" :value="__('NIP')" />

                    <x-text-input 
                        id="nip" 
                        class="block mt-1 w-full" 
                        type="text" 
                        name="nip" 
                        :value="old('nip', $pegawai->nip)" 
                        required 
                    />

                    <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                </div>

                <!-- Nama -->
                <div>
                    <x-input-label for="nama" :value="__('Nama Lengkap')" />

                    <x-text-input 
                        id="nama" 
                        class="block mt-1 w-full" 
                        type="text" 
                        name="nama" 
                        :value="old('nama', $pegawai->nama)" 
                        required 
                    />

                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />

                    <select 
                        id="jenis_kelamin" 
                        name="jenis_kelamin"
                        class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition"
                        required
                    >
                        <option value="">-- Pilih Jenis Kelamin --</option>

                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>

                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>

                <!-- Pangkat -->
                <div>
                    <x-input-label for="pangkat" :value="__('Pangkat')" />

                    <x-text-input 
                        id="pangkat" 
                        class="block mt-1 w-full" 
                        type="text" 
                        name="pangkat" 
                        :value="old('pangkat', $pegawai->pangkat)" 
                        placeholder="Opsional"
                    />

                    <x-input-error :messages="$errors->get('pangkat')" class="mt-2" />
                </div>

                <!-- Unit Kerja -->
                <div class="md:col-span-2">
                    <x-input-label for="unit_kerja_id" :value="__('Unit Kerja')" />

                    <select 
                        id="unit_kerja_id" 
                        name="unit_kerja_id"
                        class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition"
                        required
                    >
                        <option value="">-- Pilih Unit Kerja --</option>

                        @foreach($unitKerja as $unit)
                            <option value="{{ $unit->id }}"
                                {{ old('unit_kerja_id', $pegawai->unit_kerja_id) == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('unit_kerja_id')" class="mt-2" />
                </div>

            </div>

                <!-- FOOTER -->
                <div class="flex items-center justify-end mt-6 gap-3">

                    {{-- BACK BUTTON --}}
                    <a href="{{ route('admin.pegawai.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 hover:scale-[1.02] transition">

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
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl
                        bg-[#1D4ED8] hover:bg-[#1E40AF]
                        text-white font-semibold shadow-lg hover:scale-[1.02] transition"
                    >

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
                    </button>

                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
