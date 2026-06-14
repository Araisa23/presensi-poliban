<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">

            <a href="{{ route('admin.kalender-akademik.index') }}"
               class="w-10 h-10 rounded-2xl border border-slate-200 bg-white
               flex items-center justify-center text-slate-500
               hover:border-[#0b3c70] hover:text-[#0b3c70] shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                    Tambah Libur / Agenda
                </h2>
                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Tambahkan hari libur nasional atau agenda akademik kampus.
                </p>
            </div>

        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-7 sm:p-9"
             x-data="{
                jenis: '{{ old('jenis', 'akademik') }}',
                isLibur: {{ old('is_libur', '0') === '1' ? 'true' : 'false' }},

                // Saat jenis berubah: nasional otomatis libur, akademik default tidak libur
                onJenisChange() {
                    if (this.jenis === 'nasional') {
                        this.isLibur = true;
                    } else {
                        this.isLibur = false;
                    }
                }
             }">

            <form action="{{ route('admin.kalender-akademik.store') }}" method="POST">
                @csrf

                {{-- VALIDATION ERRORS --}}
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                        <p class="font-black mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- JENIS --}}
                <div class="mb-6">
                    <label class="block text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-2">
                        Jenis
                    </label>
                    <select name="jenis"
                            x-model="jenis"
                            @change="onJenisChange()"
                            class="w-full rounded-2xl border border-slate-300 bg-white
                            px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                            focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none">
                        <option value="akademik">Agenda Akademik</option>
                        <option value="nasional">Libur Nasional</option>
                    </select>
                    <p class="mt-1.5 text-xs text-slate-400">
                        <span x-show="jenis === 'akademik'">Contoh: Minggu UAS, Dies Natalis, Wisuda — pegawai bisa tetap presensi.</span>
                        <span x-show="jenis === 'nasional'">Contoh: Lebaran, Natal, Tahun Baru — otomatis dihitung hari libur.</span>
                    </p>
                </div>

                {{-- JUDUL --}}
                <div class="mb-6">
                    <label class="block text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-2">
                        Judul
                    </label>
                    <input
                        type="text"
                        name="judul"
                        value="{{ old('judul') }}"
                        required
                        placeholder="Contoh: Minggu UAS Semester Ganjil"
                        class="w-full rounded-2xl border border-slate-300 bg-white
                        px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                        focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none"
                    >
                </div>

                {{-- RENTANG TANGGAL --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-2">
                            Tanggal Mulai
                        </label>
                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-white
                            px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                            focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none"
                        >
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-2">
                            Tanggal Selesai
                            <span class="normal-case font-medium text-slate-400 tracking-normal">(Opsional)</span>
                        </label>
                        <input
                            type="date"
                            name="tanggal_selesai"
                            value="{{ old('tanggal_selesai') }}"
                            class="w-full rounded-2xl border border-slate-300 bg-white
                            px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                            focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none"
                        >
                        <p class="mt-1.5 text-xs text-slate-400">Kosongi jika hanya 1 hari.</p>
                    </div>
                </div>

                {{-- IS LIBUR TOGGLE --}}
                <div class="mb-6">
                    <div class="flex items-start justify-between gap-4 p-5 rounded-2xl border-2 transition-all duration-200"
                         :class="isLibur ? 'border-rose-200 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50'">

                        <div class="flex-1">
                            <p class="text-sm font-black text-slate-800 flex items-center gap-2">
                                <span x-show="isLibur" class="text-rose-600">🚫</span>
                                <span x-show="!isLibur" class="text-emerald-600">✅</span>
                                <span x-show="isLibur">Ini adalah hari libur</span>
                                <span x-show="!isLibur">Bukan hari libur</span>
                            </p>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">
                                <span x-show="isLibur" class="text-rose-600 font-semibold">
                                    Pegawai <strong>tidak perlu</strong> presensi pada tanggal ini. Hari ini dikecualikan dari perhitungan hari kerja.
                                </span>
                                <span x-show="!isLibur" class="text-emerald-700 font-semibold">
                                    Pegawai <strong>tetap wajib</strong> presensi. Agenda ini hanya untuk informasi di kalender.
                                </span>
                            </p>
                        </div>

                        {{-- TOGGLE SWITCH --}}
                        <button
                            type="button"
                            @click="isLibur = !isLibur"
                            class="relative inline-flex h-7 w-12 items-center rounded-full
                            transition-colors duration-200 focus:outline-none flex-shrink-0 mt-0.5"
                            :class="isLibur ? 'bg-rose-500' : 'bg-slate-300'"
                        >
                            <span
                                class="inline-block h-5 w-5 transform rounded-full bg-white shadow-sm
                                transition-transform duration-200"
                                :class="isLibur ? 'translate-x-6' : 'translate-x-1'"
                            ></span>
                        </button>

                        {{-- Hidden input --}}
                        <input type="hidden" name="is_libur" :value="isLibur ? '1' : '0'">

                    </div>

                    {{-- Info tambahan untuk Akademik non-libur --}}
                    <div x-show="jenis === 'akademik' && !isLibur"
                         x-transition
                         class="mt-3 p-3 rounded-xl bg-blue-50 border border-blue-100 text-xs text-blue-700 font-medium flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Agenda ini akan tampil di kalender sebagai informasi saja. Absensi pegawai tetap dihitung normal pada hari-hari tersebut.
                    </div>

                    {{-- Info tambahan untuk libur --}}
                    <div x-show="isLibur"
                         x-transition
                         class="mt-3 p-3 rounded-xl bg-rose-50 border border-rose-100 text-xs text-rose-700 font-medium flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Tanggal ini akan dikecualikan dari perhitungan hari kerja dan tidak dihitung alpha bagi pegawai yang tidak hadir.
                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="mb-8">
                    <label class="block text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-2">
                        Keterangan
                        <span class="normal-case font-medium text-slate-400 tracking-normal">(Opsional)</span>
                    </label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                        class="w-full rounded-2xl border border-slate-300 bg-white
                        px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                        focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none resize-none"
                    >{{ old('keterangan') }}</textarea>
                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">

                    <a href="{{ route('admin.kalender-akademik.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl
                       border border-slate-300 bg-white text-slate-700 text-sm font-bold
                       hover:bg-slate-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl
                            font-black text-xs uppercase tracking-[0.18em]
                            bg-gradient-to-r from-[#004b8d] to-[#006fcf]
                            text-white shadow-sm hover:opacity-90 hover:scale-[1.01] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>

                </div>

            </form>
        </div>
    </div>
</x-app-layout>