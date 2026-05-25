<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Edit Libur / Agenda') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
                    Edit hari libur nasional atau agenda akademik kampus.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">

            <form action="{{ route('admin.kalender-akademik.update', $kalenderAkademik->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- JENIS --}}
                <div class="mb-5">
                    <label class="block font-bold mb-2 text-slate-700 dark:text-slate-200">
                        Jenis
                    </label>

                    <select
                        name="jenis"
                        class="w-full rounded-2xl border-slate-300 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-2 focus:ring-[#006fcf]"
                    >
                        <option value="akademik"
                            {{ old('jenis', $kalenderAkademik->jenis) == 'akademik' ? 'selected' : '' }}>
                            Agenda Akademik
                        </option>

                        <option value="nasional"
                            {{ old('jenis', $kalenderAkademik->jenis) == 'nasional' ? 'selected' : '' }}>
                            Libur Nasional
                        </option>
                    </select>
                </div>

                {{-- JUDUL --}}
                <div class="mb-5">
                    <label class="block font-bold mb-2 text-slate-700 dark:text-slate-200">
                        Judul Libur / Agenda
                    </label>

                    <input
                        type="text"
                        name="judul"
                        value="{{ old('judul', $kalenderAkademik->judul) }}"
                        required
                        class="w-full rounded-2xl border-slate-300 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-2 focus:ring-[#006fcf]"
                        placeholder="Contoh: Libur Semester Ganjil"
                    >
                </div>

                {{-- TANGGAL --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                    <div>
                        <label class="block font-bold mb-2 text-slate-700 dark:text-slate-200">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', $kalenderAkademik->tanggal_mulai) }}"
                            required
                            class="w-full rounded-2xl border-slate-300 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-2 focus:ring-[#006fcf]"
                        >
                    </div>

                    <div>
                        <label class="block font-bold mb-2 text-slate-700 dark:text-slate-200">
                            Tanggal Selesai
                            <span class="text-sm font-normal text-slate-400">(Opsional)</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            value="{{ old('tanggal_selesai', $kalenderAkademik->tanggal_selesai) }}"
                            class="w-full rounded-2xl border-slate-300 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-2 focus:ring-[#006fcf]"
                        >

                        <p class="mt-1 text-xs text-slate-500">
                            Kosongi jika hanya 1 hari.
                        </p>
                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="mb-5">
                    <label class="block font-bold mb-2 text-slate-700 dark:text-slate-200">
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        rows="3"
                        class="w-full rounded-2xl border-slate-300 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-2 focus:ring-[#006fcf]"
                    >{{ old('keterangan', $kalenderAkademik->keterangan) }}</textarea>
                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-end mt-6 gap-3">

                    <a href="{{ route('admin.kalender-akademik.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition">

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

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-[#0b3c70] to-[#006fcf] text-white font-black shadow-[0_10px_25px_rgba(11,_60,_112,_0.25)] hover:scale-[1.01] transition"
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

                        Update Libur / Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>