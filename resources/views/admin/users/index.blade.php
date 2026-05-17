<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            
            <!-- LEFT -->
            <div>
                <p class="text-[#facc15] text-xs font-black uppercase tracking-[0.3em]">
                    Admin Panel
                </p>

                <h2 class="text-3xl font-black text-white leading-tight mt-1">
                    {{ __('Manajemen User') }}
                </h2>

                <p class="mt-2 text-white/70 text-sm">
                    Kelola akun pegawai, admin, dan pimpinan.
                </p>
            </div>

            <!-- RIGHT -->
            <div class="flex flex-wrap gap-3">

                <!-- TAMBAH USER -->
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl 
                    bg-[#facc15] text-[#0b3c70] font-black shadow-lg 
                    hover:bg-yellow-300 transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"/>
                    </svg>

                    Tambah User
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <!-- CARD -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

            <!-- TOP -->
            <div class="p-6 border-b border-slate-100">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <!-- TITLE -->
                    <div>
                        <h3 class="text-xl font-black text-[#0b3c70]">
                            Daftar Pengguna Sistem
                        </h3>

                        <p class="text-slate-500 text-sm mt-1">
                            Total User: {{ $users->count() }}
                        </p>
                    </div>

                    <!-- SEARCH -->
                    <div class="w-full lg:w-80">
                        <input 
                            type="text"
                            placeholder="Cari user..."
                            class="w-full rounded-2xl border border-slate-200 
                            px-5 py-3 text-sm focus:ring-2 focus:ring-[#0b3c70] 
                            focus:border-[#0b3c70] outline-none"
                        >
                    </div>

                </div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full">

                    <!-- HEAD -->
                    <thead class="bg-[#0b3c70] text-white">

                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest">
                                Nama
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest">
                                NIP
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest">
                                Email
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest">
                                Role
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase tracking-widest">
                                Aksi
                            </th>
                        </tr>

                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y divide-slate-100">

                        @forelse($users as $user)

                            <tr class="hover:bg-slate-50 transition">

                                <!-- NAMA -->
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <!-- AVATAR -->
                                        <div class="w-11 h-11 rounded-2xl bg-[#0b3c70] text-white flex items-center justify-center font-black">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <!-- INFO -->
                                        <div>
                                            <div class="font-bold text-slate-800">
                                                {{ $user->name }}
                                            </div>

                                            <div class="text-xs text-slate-400">
                                                Pengguna Sistem
                                            </div>
                                        </div>

                                    </div>

                                </td>

                                <!-- NIP -->
                                <td class="px-6 py-5 text-sm font-semibold text-slate-700">
                                    {{ $user->nip }}
                                </td>

                                <!-- EMAIL -->
                                <td class="px-6 py-5 text-sm text-slate-600">
                                    {{ $user->email ?? '-' }}
                                </td>

                                <!-- ROLE -->
                                <td class="px-6 py-5">

                                    @if($user->role_id == 1)

                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black bg-blue-100 text-blue-700">
                                            Admin
                                        </span>

                                    @elseif($user->role_id == 2)

                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black bg-emerald-100 text-emerald-700">
                                            Pegawai
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black bg-yellow-100 text-yellow-700">
                                            Pimpinan
                                        </span>

                                    @endif

                                </td>

                                <!-- AKSI -->
                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        <!-- EDIT -->
                                        <a href="#"
                                            class="px-4 py-2 rounded-xl bg-[#0b3c70] text-white text-xs font-bold hover:bg-[#082b50] transition">
                                            Edit
                                        </a>

                                        <!-- DELETE -->
                                        <button
                                            class="px-4 py-2 rounded-xl bg-red-500 text-white text-xs font-bold hover:bg-red-600 transition">
                                            Hapus
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="py-16 text-center">

                                    <div class="flex flex-col items-center justify-center">

                                        <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-4">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-10 h-10 text-slate-400"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>

                                        </div>

                                        <h3 class="text-lg font-black text-slate-700">
                                            Belum Ada User
                                        </h3>

                                        <p class="text-slate-400 mt-1">
                                            Tambahkan pengguna baru atau import dari Excel.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</x-app-layout>