<x-app-layout>

    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#0b3c70]">
            Tambah Kalender Akademik
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="bg-white rounded-3xl p-6 shadow-lg">

            <form action="{{ route('admin.kalender-akademik.store') }}" method="POST">

                @csrf

                <div class="mb-5">
                    <label class="block font-bold mb-2">Judul Event</label>

                    <input type="text"
                           name="judul"
                           class="w-full rounded-2xl border-slate-300">
                </div>

                <div class="mb-5">
                    <label class="block font-bold mb-2">Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           class="w-full rounded-2xl border-slate-300">
                </div>

                <div class="mb-5">
                    <label class="block font-bold mb-2">Keterangan</label>

                    <textarea name="keterangan"
                              rows="4"
                              class="w-full rounded-2xl border-slate-300"></textarea>
                </div>

                <button class="px-5 py-3 rounded-2xl bg-[#0b3c70] text-white font-bold">
                    Simpan
                </button>

            </form>

        </div>

    </div>

</x-app-layout>