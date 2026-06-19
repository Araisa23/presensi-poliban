<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah User') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">Buat akun baru dan tentukan role.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- NIP -->
                    <div>
                        <x-input-label for="nip" :value="__('NIP')" />
                        <x-text-input 
                            id="nip" 
                            class="block mt-1 w-full" 
                            type="text" 
                            name="nip" 
                            :value="old('nip', $user->nip)" 
                            required 
                        />
                        <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />

                        <x-text-input
                            id="email"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="old('email', $user->email ?? '')"
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <!-- Nama -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input 
                            id="name" 
                            class="block mt-1 w-full" 
                            type="text" 
                            name="name" 
                            :value="old('name', $user->name)" 
                            required 
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
                            <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
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
                            :value="old('pangkat', $user->pangkat)" 
                            placeholder="Opsional"
                        />
                        <x-input-error :messages="$errors->get('pangkat')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="md:col-span-2">
                        <x-input-label for="role_id" :value="__('Role')" />

                        <select 
                            id="role_id" 
                            name="role_id"
                            class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition"
                            required
                        >
                            <option value="">-- Pilih Role Akses --</option>
                            <option value="2" {{ old('role_id', $user->role_id) == '2' ? 'selected' : '' }}>Pegawai</option>
                            <option value="1" {{ old('role_id', $user->role_id) == '1' ? 'selected' : '' }}>Admin</option>
                            <option value="3" {{ old('role_id', $user->role_id) == '3' ? 'selected' : '' }}>Pimpinan</option>
                        </select>

                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div>

                </div>

                <!-- FOOTER BUTTONS -->
                <div class="flex items-center justify-end mt-6 gap-3">

                    {{-- BACK BUTTON --}}
                    <x-back-button href="{{ url()->previous() }}">
                        Kembali
                    </x-back-button>

                    {{-- SAVE BUTTON --}}
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#1D4ED8] hover:bg-[#1E40AF] text-white font-semibold shadow-lg hover:scale-[1.02] transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan User
                    </button>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>