<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pegawai.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Tenaga Kependidikan') }}
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Hubungkan akun user pegawai dan isi profil kepegawaian.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                <form action="{{ route('admin.pegawai.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User ID Selection -->
                        <div class="md:col-span-2">
                            <x-input-label for="user_id" :value="__('Pilih Akun User')" />
                            <select id="user_id" name="user_id" class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition" required>
                                <option value="">-- Pilih Akun --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            <p class="text-xs text-gray-400 mt-1 italic italic">Hanya menampilkan user dengan role 'pegawai' yang belum memiliki profil tenaga kependidikan.</p>
                        </div>

                        <div>
                            <x-input-label for="nip" :value="__('NIP')" />
                            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" required />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="unit_kerja_id" :value="__('Unit Kerja')" />
                            <select id="unit_kerja_id" name="unit_kerja_id" class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition" required>
                                <option value="">-- Pilih Unit --</option>
                                @foreach($unitKerja as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('unit_kerja_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Simpan Data Pegawai') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
