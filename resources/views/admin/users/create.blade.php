<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-black-70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah User') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">Buat akun baru dan tentukan role.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-900 shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                @csrf

                <!-- NIP -->
                <div>
                    <label class="block mb-2 font-bold text-slate-700">
                        NIP
                    </label>

                    <input 
                        type="text"
                        name="nip"
                        required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3"
                    >
                </div>

                <!-- Nama -->
                <div>
                    <label class="block mb-2 font-bold text-slate-700">
                        Nama Lengkap
                    </label>

                    <input 
                        type="text"
                        name="name"
                        required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3"
                    >
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block mb-2 font-bold text-slate-700">
                        Jenis Kelamin
                    </label>

                    <select 
                        name="jenis_kelamin"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3"
                    >
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <!-- Pangkat -->
                <div>
                    <label class="block mb-2 font-bold text-slate-700">
                        Pangkat
                    </label>

                    <input 
                        type="text"
                        name="pangkat"
                        placeholder="Opsional"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3"
                    >
                </div>

                <!-- Role -->
                <div>
                    <label class="block mb-2 font-bold text-slate-700">
                        Role
                    </label>

                    <select 
                        name="role_id"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3"
                    >
                        <option value="2">Pegawai</option>
                        <option value="1">Admin</option>
                        <option value="3">Pimpinan</option>
                    </select>
                </div>

                <!-- BUTTON -->
                <button 
                    type="submit"
                    class="w-full bg-[#0b3c70] text-white font-bold py-3 rounded-2xl"
                >
                    Simpan User
                </button>
            </form>

            </div>
    </div>
</x-app-layout>