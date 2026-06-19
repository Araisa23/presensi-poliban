<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Lokasi Kantor') }}
                </h2>

                <p class="mt-1 text-slate-500 text-sm font-medium">
                    Kelola titik koordinat kantor dan radius presensi.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 shadow-soft">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM --}}
        <form
            action="{{ route('admin.lokasi-kantor.update', $lokasiKantor->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            {{-- MAP --}}
            <div class="mb-6 bg-white rounded-3xl p-6 shadow-soft border border-slate-100">

                <div class="flex items-center justify-between mb-4">

                    <div>
                        <h3 class="text-xl font-black text-slate-800">
                            {{ $lokasiKantor->nama_lokasi }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Radius presensi pegawai berdasarkan titik lokasi kantor.
                        </p>
                    </div>

                    <span class="px-4 py-2 rounded-2xl bg-blue-50 text-blue-700 text-xs font-black uppercase tracking-[0.15em]">
                        Lokasi Aktif
                    </span>

                </div>

                <div
                    id="map"
                    class="w-full h-[450px] rounded-3xl border border-slate-200 overflow-hidden z-10">
                </div>

            </div>

            {{-- INFO --}}
            <div class="bg-white rounded-3xl p-6 shadow-soft border border-slate-100">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- LATITUDE --}}
                    <div>

                        <label class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">
                            Latitude
                        </label>

                        <input
                            type="text"
                            name="latitude"
                            value="{{ $lokasiKantor->latitude }}"
                            readonly
                            class="mt-2 w-full p-4 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-bold"
                        >

                    </div>

                    {{-- LONGITUDE --}}
                    <div>

                        <label class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">
                            Longitude
                        </label>

                        <input
                            type="text"
                            name="longitude"
                            value="{{ $lokasiKantor->longitude }}"
                            readonly
                            class="mt-2 w-full p-4 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-bold"
                        >

                    </div>

                    {{-- RADIUS --}}
                    <div>

                        <label class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">
                            Radius (Meter)
                        </label>

                        <input
                            type="number"
                            name="radius"
                            id="radiusInput"
                            value="{{ $lokasiKantor->radius }}"
                            class="mt-2 w-full p-4 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-bold focus:ring-2 focus:ring-blue-500"
                        >

                    </div>

                </div>

                {{-- HIDDEN --}}
                <input
                    type="hidden"
                    name="nama_lokasi"
                    value="{{ $lokasiKantor->nama_lokasi }}"
                >

            {{-- BUTTON --}}
            <div class="mt-8 flex items-center justify-between">

                {{-- DELETE --}}
                <div x-data="{ openDeleteModal: false }">

                    <x-danger-button
                        type="button"
                        @click="openDeleteModal = true"
                    >
                        Hapus Lokasi
                    </x-danger-button>

                    {{-- MODAL DELETE --}}
                    <div
                        x-show="openDeleteModal"
                        x-transition.opacity
                        class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        style="display: none;"
                    >

                        {{-- OVERLAY --}}
                        <div
                            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                            @click="openDeleteModal = false"
                        ></div>

                        {{-- CONTENT --}}
                        <div
                            x-transition.scale
                            class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden"
                        >

                            <div class="p-8">

                                {{-- ICON --}}
                                <div class="w-16 h-16 mx-auto rounded-3xl bg-rose-100 text-rose-600 flex items-center justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-8 h-8"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"
                                        />
                                    </svg>

                                </div>

                                {{-- TEXT --}}
                                <div class="mt-6 text-center">

                                    <h3 class="text-2xl font-black text-slate-900">
                                        Hapus Lokasi?
                                    </h3>

                                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                                        Lokasi kantor
                                        <span class="font-bold text-rose-600">
                                            {{ $lokasiKantor->nama_lokasi }}
                                        </span>
                                        akan dihapus permanen.
                                    </p>

                                </div>

                                {{-- BUTTON --}}
                                <div class="mt-8 flex items-center justify-center gap-3">

                                    {{-- CANCEL --}}
                                    <button
                                        type="button"
                                        @click="openDeleteModal = false"
                                        class="px-5 py-2.5 rounded-2xl border border-slate-300 bg-white text-slate-700 font-semibold hover:bg-slate-100 transition"
                                    >
                                        Batal
                                    </button>
                                
                                    {{-- DELETE FORM --}}
                                    <form
                                        action="{{ route('admin.lokasi-kantor.destroy', $lokasiKantor->id) }}"
                                        method="POST"
                                    >
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

                {{-- SAVE BUTTON --}}
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
                        Simpan Radius
                    </x-primary-button>   

            </div>

            </div>

        </form>

    </div>

    {{-- LEAFLET --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>

        const polibanLat = {{ $lokasiKantor->latitude }};
        const polibanLng = {{ $lokasiKantor->longitude }};

        const map = L.map('map').setView([polibanLat, polibanLng], 17);

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);

        const marker = L.marker([polibanLat, polibanLng]).addTo(map);

        marker
            .bindPopup('{{ $lokasiKantor->nama_lokasi }}')
            .openPopup();

        let circle = L.circle(
            [polibanLat, polibanLng],
            {
                radius: {{ $lokasiKantor->radius }},
                color: '#2563eb',
                fillColor: '#3b82f6',
                fillOpacity: 0.2
            }
        ).addTo(map);

        // UPDATE RADIUS
        document
            .getElementById('radiusInput')
            .addEventListener('input', function () {

                map.removeLayer(circle);

                circle = L.circle(
                    [polibanLat, polibanLng],
                    {
                        radius: this.value,
                        color: '#2563eb',
                        fillColor: '#3b82f6',
                        fillOpacity: 0.2
                    }
                ).addTo(map);

            });

    </script>

</x-app-layout>