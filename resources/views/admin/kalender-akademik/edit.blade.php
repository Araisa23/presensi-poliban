{{-- resources/views/admin/kalender-akademik/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">

        <div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                Edit Libur / Agenda
            </h2>

            <p class="mt-1 text-slate-500 text-sm font-medium">
                Perbarui informasi libur nasional atau agenda akademik.
            </p>
        </div>

    </div>
</x-slot>

<div class="max-w-2xl mx-auto">

    <div
        class="bg-white rounded-3xl border border-slate-200 shadow-sm p-7 sm:p-9"
        x-data="{
            jenis: '{{ old('jenis', $kalenderAkademik->jenis) }}',
            isLibur: {{ old('is_libur', $kalenderAkademik->is_libur) ? 'true' : 'false' }},

            onJenisChange() {
                if (this.jenis === 'nasional') {
                    this.isLibur = true;
                }
            }
        }"
    >

        <form action="{{ route('admin.kalender-akademik.update', $kalenderAkademik->id) }}"
              method="POST">

            @csrf
            @method('PUT')

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

                <select
                    name="jenis"
                    x-model="jenis"
                    @change="onJenisChange()"
                    class="w-full rounded-2xl border border-slate-300 bg-white
                    px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                    focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none">

                    <option value="akademik">Agenda Akademik</option>
                    <option value="nasional">Libur Nasional</option>

                </select>

                <p class="mt-1.5 text-xs text-slate-400">
                    <span x-show="jenis === 'akademik'">
                        Agenda kampus yang tidak selalu menjadi hari libur.
                    </span>

                    <span x-show="jenis === 'nasional'">
                        Hari libur resmi yang dikecualikan dari perhitungan presensi.
                    </span>
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
                    value="{{ old('judul', $kalenderAkademik->judul) }}"
                    required
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
                        value="{{ old('tanggal_mulai', $kalenderAkademik->tanggal_mulai) }}"
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
                        value="{{ old('tanggal_selesai', $kalenderAkademik->tanggal_selesai) }}"
                        class="w-full rounded-2xl border border-slate-300 bg-white
                        px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                        focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none"
                    >

                    <p class="mt-1.5 text-xs text-slate-400">
                        Kosongi jika hanya 1 hari.
                    </p>
                </div>

            </div>

            {{-- TOGGLE LIBUR --}}
            <div class="mb-6">

                <div
                    class="flex items-start justify-between gap-4 p-5 rounded-2xl border-2 transition-all duration-200"
                    :class="isLibur ? 'border-rose-200 bg-rose-50/50' : 'border-slate-200 bg-slate-50/50'">

                    <div class="flex-1">

                        <p class="text-sm font-black text-slate-800 flex items-center gap-2">
                            <span x-show="isLibur">🚫</span>
                            <span x-show="!isLibur">✅</span>

                            <span x-show="isLibur">
                                Ini adalah hari libur
                            </span>

                            <span x-show="!isLibur">
                                Bukan hari libur
                            </span>
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Status ini menentukan apakah tanggal dihitung sebagai hari kerja atau tidak.
                        </p>

                    </div>

                    <button
                        type="button"
                        @click="isLibur = !isLibur"
                        class="relative inline-flex h-7 w-12 items-center rounded-full"
                        :class="isLibur ? 'bg-rose-500' : 'bg-slate-300'">

                        <span
                            class="inline-block h-5 w-5 transform rounded-full bg-white transition"
                            :class="isLibur ? 'translate-x-6' : 'translate-x-1'">
                        </span>

                    </button>

                    <input
                        type="hidden"
                        name="is_libur"
                        :value="isLibur ? '1' : '0'"
                    >

                </div>

            </div>

            {{-- KETERANGAN --}}
            <div class="mb-8">
                <label class="block text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-2">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="3"
                    class="w-full rounded-2xl border border-slate-300 bg-white
                    px-4 py-3 text-sm font-medium text-slate-700 shadow-sm
                    focus:ring-2 focus:ring-[#0b3c70] focus:border-[#0b3c70] focus:outline-none resize-none"
                >{{ old('keterangan', $kalenderAkademik->keterangan) }}</textarea>
            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">

                <x-back-button href="{{ route('admin.kalender-akademik.index') }}">
                    Kembali
                </x-back-button>

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

                    Update Libur / Agenda
                </x-primary-button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>
