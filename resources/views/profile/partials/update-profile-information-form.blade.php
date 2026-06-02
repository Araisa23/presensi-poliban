<div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm">
    <header class="mb-5">
        <h3 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            Informasi Profil
        </h3>
        <p class="text-xs text-slate-400 mt-0.5">Perbarui nama dan alamat email akun Anda</p>
    </header>

    <form method="POST"
      action="{{ route('profile.update') }}"
      enctype="multipart/form-data"
      class="space-y-4"
      onsubmit="alert('FORM TERKIRIM')">
        @csrf
        @method('patch')
<p id="selected-file" class="text-xs text-slate-500 mt-2"></p>

<script>
document.getElementById('foto').addEventListener('change', function() {
    if(this.files.length > 0){
        document.getElementById('selected-file').textContent =
            this.files[0].name;
    }
});
</script>
        {{-- Hidden input file yang di-trigger via label kolom kiri --}}
        <input
            type="file"
            id="foto"
            name="foto"
            class="hidden"
            accept="image/*"
        >

        <p id="selected-file"
        class="text-xs text-slate-500">
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Nama Lengkap --}}
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-semibold text-slate-600 mb-1" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </span>
                    <input id="name" name="name" type="text" class="pl-10 w-full rounded-xl border-slate-200 bg-slate-50/50 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('name', $user->display_name) }}" required autocomplete="name">
                </div>
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('name')" />
            </div>

            {{-- Alamat Email --}}
            <div>
                <x-input-label for="email" :value="__('Alamat Email')" class="text-xs font-semibold text-slate-600 mb-1" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </span>
                    <input id="email" name="email" type="email" class="pl-10 w-full rounded-xl border-slate-200 bg-slate-50/50 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('email', $user->email) }}" required autocomplete="username">
                </div>
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('email')" />
            </div>
        </div>

        {{-- Baris Tambahan (NIP & Jenis Kelamin) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <div>
                <x-input-label for="nip" :value="__('NIP')" class="text-xs font-semibold text-slate-600 mb-1" />
                <input id="nip" name="nip" type="text" class="w-full rounded-xl border-slate-200 bg-slate-50/50 dark:border-slate-700 dark:bg-slate-900/50 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('nip', $user->display_nip) }}">
            </div>
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" class="text-xs font-semibold text-slate-600 mb-1" />
                <select id="jenis_kelamin" name="jenis_kelamin" class="w-full rounded-xl border-slate-200 bg-slate-50/50 dark:border-slate-700 dark:bg-slate-900/50 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end pt-3 border-t border-slate-50 dark:border-slate-700/50">
            <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                Simpan Perubahan
            </button>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {

            const fotoInput = document.getElementById('foto');
            const fileText = document.getElementById('selected-file');

            if (fotoInput) {
                fotoInput.addEventListener('change', function () {

                    if (this.files.length > 0) {
                        fileText.textContent =
                            'Foto dipilih: ' + this.files[0].name;
                    }

                });
            }

        });
        </script>
    </form>
</div>