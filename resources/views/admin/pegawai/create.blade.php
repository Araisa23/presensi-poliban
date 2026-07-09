<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Tenaga Kependidikan') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">Tambahkan data tenaga kependidikan baru.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                <form action="{{ route('admin.pegawai.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- NIP -->
    <div>
        <x-input-label for="nip" :value="__('NIP')" />
        <x-text-input 
            id="nip" 
            class="block mt-1 w-full" 
            type="text" 
            name="nip" 
            :value="old('nip')" 
            required 
            maxlength="18"
            minlength="18"
            inputmode="numeric"
            pattern="\d{18}"
            title="NIP harus terdiri dari tepat 18 digit angka"
            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18)"
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
                :value="old('nama')" 
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
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                    L
                </option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                    P
                </option>
            </select>

            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
        </div>

        <!-- Pangkat -->
        <div>
            <x-input-label for="pangkat" :value="__('Pangkat')" />
            <x-text-input 
                id="pangkat" 
                class="block mt-2 w-full" 
                type="text" 
                name="pangkat" 
                :value="old('pangkat')" 
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
                    <option value="{{ $unit->id }}" {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>
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
                    <x-back-button href="{{ route('admin.pegawai.index') }}">
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

                        Simpan Pegawai

                    </x-primary-button>

                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
