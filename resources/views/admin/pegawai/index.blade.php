<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Daftar Tenaga Kependidikan') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
                    Kelola data pegawai, unit kerja, dan akun terkait.
                </p>
            </div>

            <!-- BUTTON AREA -->
            <div class="flex items-center gap-3 flex-wrap">

                <!-- IMPORT BUTTON -->
                <button
                    onclick="openImportModal()"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-[#0b3c70] font-bold shadow-lg hover:scale-[1.02] transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 4v12m0 0l-3-3m3 3l3-3"/>
                    </svg>

                    Import Excel
                </button>

                <!-- TAMBAH -->
                <a href="{{ route('admin.pegawai.create') }}"
                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] 
                text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 hover:scale-[1.02] transition min-w-[180px]">
                + Tambah Pegawai
            </a>

            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-emerald-800 shadow-soft">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50/70 border border-rose-200 text-rose-800 shadow-soft">
                {{ session('error') }}
            </div>
        @endif

        {{-- FILTER --}}
        <form method="GET" action="{{ route('admin.pegawai.index') }}" class="mb-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100/70 dark:border-white/10 shadow-soft p-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Cari Pegawai
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIP..."
                            class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                            Unit Kerja
                        </label>
                        <select name="unit_kerja" class="w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Unit Kerja</option>
                            @foreach($unitKerja as $uk)
                                <option value="{{ $uk->id }}" {{ request('unit_kerja') == $uk->id ? 'selected' : '' }}>
                                    {{ $uk->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)] hover:scale-[1.01] transition">
                            Filter
                        </button>
                        <a href="{{ route('admin.pegawai.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-white/10 transition">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- TABLE -->
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-white/5">

                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b">
                                NIP
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b">
                                Nama Lengkap
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b">
                                Jenis Kelamin
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b">
                                Pangkat
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b">
                                Unit Kerja
                            </th>

                             <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b">
                                Device
                            </th>

                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] border-b text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100/70 dark:divide-white/10">

                        @forelse($pegawai as $p)

                            <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">

                                <!-- NIP -->
                                <td class="px-6 py-5 text-sm font-black text-slate-800 dark:text-slate-300">
                                    {{ $p->nip }}
                                </td>

                                <!-- NAMA -->
                                <td class="px-6 py-5">

                                    <div class="text-sm font-black text-slate-800 dark:text-slate-100">
                                        {{ $p->nama }}
                                    </div>

                                    <div class="text-xs font-medium text-slate-400">
                                        {{ $p->user->email ?? 'Belum mengisi email' }}
                                    </div>

                                </td>

                                <!-- JK -->
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-300">
                                    {{ $p->jenis_kelamin ?? '-' }}
                                </td>

                                <!-- PANGKAT -->
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-300">
                                    {{ $p->pangkat ?? '-' }}
                                </td>

                                <!-- UNIT -->
                                <td class="px-6 py-5">

                                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-black ring-1 ring-indigo-600/10">

                                        {{ $p->unitKerja->nama_unit ?? '-' }}

                                    </span>

                                </td>

                                <!-- DEVICE -->
                                <td class="px-6 py-5">

                                    @if($p->user)
                                        <div class="text-xs {{ $p->user->device_id ? 'text-emerald-600' : 'text-slate-400' }} font-bold mb-1">
                                            {{ $p->user->device_id ? '✅ Terdaftar' : '⚪ Belum terdaftar' }}
                                        </div>

                                        @if($p->user->device_id && $p->user->device_registered_at)
                                            <div class="text-[10px] text-slate-400 mb-2">
                                                Sejak {{ $p->user->device_registered_at->format('d M Y') }}
                                            </div>
                                        @endif

                                        @if($p->user->device_id)
                                            <form action="{{ route('admin.users.reset-device', $p->user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin reset device untuk {{ $p->nama }}? Pegawai perlu presensi ulang dari device baru.')">
                                                @csrf
                                                <button type="submit" class="text-[10px] font-bold text-rose-600 hover:underline">
                                                    Reset Device
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-xs text-slate-300 italic">Belum ada akun</span>
                                    @endif

                                </td>

                                <!-- AKSI -->
                                <td class="px-6 py-5 text-right">

                                    <div class="inline-flex items-center gap-2">

                                        <!-- EDIT -->
                                        <a href="{{ route('admin.pegawai.edit', $p->id) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 rounded-2xl text-[11px] font-black uppercase tracking-[0.18em] bg-white text-slate-700 hover:bg-slate-50 ring-1 ring-slate-900/10 shadow-soft transition">

                                            Edit
                                        </a>

                    <div x-data="{ openDeleteModal: false }">

                        {{-- DELETE BUTTON --}}
                        <button
                            type="button"
                            @click="openDeleteModal = true"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-2xl text-[11px] font-black uppercase tracking-[0.18em] bg-rose-50 text-rose-700 hover:bg-rose-100 ring-1 ring-rose-600/10 transition"
                        >
                            Hapus
                        </button>

                        {{-- MODAL --}}
                        <div
                            x-show="openDeleteModal"
                            x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                            style="display: none;"
                        >

                            {{-- OVERLAY --}}
                            <div
                                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                @click="openDeleteModal = false"
                            ></div>

                            {{-- CARD --}}
                            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

                                <div class="p-8">

                                    {{-- ICON --}}
                                    <div class="w-16 h-16 mx-auto rounded-3xl bg-rose-100 text-rose-600 flex items-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-8 h-8"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
                                        </svg>

                                    </div>

                                    {{-- TEXT --}}
                                    <div class="mt-6 text-center">

                                        <h3 class="text-xl font-black text-slate-900">
                                            Hapus Pegawai?
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                                            Data pegawai
                                            <span class="font-bold text-rose-600">
                                                {{ $p->nama }}
                                            </span>
                                            akan dihapus permanen.
                                        </p>

                                    </div>

                                    {{-- ACTION --}}
                                    <div class="mt-8 flex items-center justify-center gap-3">

                                        {{-- CANCEL --}}
                                        <button
                                            type="button"
                                            @click="openDeleteModal = false"
                                            class="px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition"
                                        >
                                            Batal
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.pegawai.destroy', $p->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-5 py-2.5 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition"
                                            >
                                                Ya, Hapus
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="px-6 py-12 text-center text-slate-400 font-medium italic">

                                    Belum ada data tenaga kependidikan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="p-6 border-t border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5">
                {{ $pegawai->links() }}
            </div>

        </div>

    </div>

    <!-- MODAL IMPORT -->
    <div id="importModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm">

        <div class="fixed inset-0 flex items-center justify-center p-4">

            <!-- CARD -->
            <div class="w-full max-w-sm bg-white rounded-[28px] shadow-2xl overflow-hidden">
                
                <!-- HEADER -->
                <div class="px-6 py-5 bg-gradient-to-r from-[#0b3c70] to-[#14508f]">

                    <h2 class="text-xl font-black text-white">
                        Import Excel
                    </h2>

                    <p class="text-blue-100 text-sm mt-1 leading-relaxed">
                        Upload data pegawai dengan format excel.
                    </p>

                </div>

                <!-- BODY -->
                <div class="p-6">

                    <form action="{{ route('admin.pegawai.import') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="space-y-5">

                        @csrf

                        <!-- FILE -->
                        <label class="border-2 border-dashed border-slate-300 rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50/40 transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 text-blue-500 mb-3"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>

                            <p class="font-bold text-slate-700 text-sm">
                                Klik untuk upload file
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                .xlsx / .xls
                            </p>

                            <input
                                type="file"
                                name="file"
                                accept=".xlsx,.xls"
                                required
                                class="hidden"
                                onchange="showFileName(this)"
                            >

                            <span id="fileName"
                                class="mt-3 text-xs font-semibold text-blue-600">
                            </span>

                        </label>

                        <!-- FORMAT -->

                        <!-- TEMPLATE -->
                        <a href="{{ route('admin.pegawai.template.download') }}"
                            class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/>
                            </svg>

                            Unduh Template
                        </a>
                        <div class="rounded-2xl bg-slate-50 p-4">

                            <p class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">
                                Format Excel
                            </p>

                            <div class="flex flex-wrap gap-2 text-xs">

                                <span class="px-2 py-1 rounded-full bg-white border text-slate-600">
                                    NIP
                                </span>

                                <span class="px-2 py-1 rounded-full bg-white border text-slate-600">
                                    Nama
                                </span>

                                <span class="px-2 py-1 rounded-full bg-white border text-slate-600">
                                    Jenis Kelamin
                                </span>

                                <span class="px-2 py-1 rounded-full bg-white border text-slate-600">
                                    Pangkat
                                </span>

                                <span class="px-2 py-1 rounded-full bg-white border text-slate-600">
                                    Unit Kerja
                                </span>

                            </div>

                        </div>

                        
                        <!-- BUTTON -->
                        <div class="flex items-center justify-end gap-3 pt-1">

                            <button
                                type="button"
                                onclick="closeImportModal()"
                                class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold transition">

                                Batal
                            </button>

                            <button
                                type="submit"
                                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#0b3c70] to-[#14508f] text-white text-sm font-black shadow-lg hover:scale-[1.02] transition">

                                Import
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
    <!-- SCRIPT -->
    <script>

        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
            document.getElementById('importModal').classList.add('flex');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
            document.getElementById('importModal').classList.remove('flex');
        }

        function showFileName(input) {

            if (input.files.length > 0) {

                document.getElementById('fileName').innerText =
                    input.files[0].name;
            }
        }

    </script>

</x-app-layout>